<?php

namespace App\Services;
use App\Events\NewOrder;
use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\StripeClient;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaymentService
{
    protected ?StripeClient $stripe;
    protected ?PayPalClient $paypal;

    public function __construct()
    {
        if (config('services.stripe.secret') && config('services.stripe.status') == '1' ) {
            $this->stripe = new StripeClient(config('services.stripe.secret'));
        }


        if (config('paypal.live.client_id')  && config('paypal.status') == '1' && config('paypal.live.client_secret') ){
            $this->paypal = new PayPalClient;
            $this->paypal->setApiCredentials(config('paypal'));
            $this->paypal->setAccessToken($this->paypal->getAccessToken());
        }
    }



    public function processStripePayment($order){

        $line_items =[];

        foreach ($order->items as  $item){
            $line_items[]=[
                'price_data' => [
                    'currency' => 'EGP',
                    'product_data' => [
                        'name' => $item->name,
                    ],
                    'unit_amount' => $item->price *100,
                ],
                'quantity' => $item->qty,
            ];
        }
        $checkout_session = $this->stripe->checkout->sessions->create([
            'customer_email' => $order->user->email,
            'line_items' =>$line_items,
            'mode' => 'payment',
            'success_url' => route('front.payment.success',['order'=>$order]) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('front.payment.cancel',['order'=>$order]),
        ]);
        $order->stripe_session_id = $checkout_session->id;
        $order->save();

        return $checkout_session->url;
    }

    public function handleStripeSuccess($session_id, $order, $user_id)
    {
        Stripe::setApiKey(config('services.stripe.secret'));
        $stripe = new StripeClient(config('services.stripe.secret'));

        $session = $stripe->checkout->sessions->retrieve($session_id);
        $paymentIntent = $stripe->paymentIntents->retrieve($session->payment_intent);



        if (!$order || $order->user->id != $user_id) {
            throw new \Exception('Order not found or user not authorized');
        }

        if ($paymentIntent->status == 'succeeded') {
            $order->payment->update(['status' => 'completed']);
        } else {
            $order->payment->update(['status' => 'failed']);
        }

        try {
            event(new NewOrder($order));
        } catch (\Exception $e) {
            Log::error('Failed to send NewOrder event: ' . $e->getMessage());
        }

        return $order;
    }




    public function processPayPalPayment($order)
    {
        $paypalOrder = [
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => 'USD',
                        'value' => number_format($order->grand_total * 0.021,2),
                    ],
                    'description' => 'Order ' . $order->order_number,
                ],
            ],
            'application_context' => [
                'cancel_url' => route('front.payment.paypal.cancel',['order'=>$order]),
                'return_url' => route('front.payment.paypal.success',['order'=>$order]),
            ],
        ];


        $response = $this->paypal->createOrder($paypalOrder);

        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] == 'approve') {
                    return redirect()->away($link['href']);
                }
            }
            return redirect()->route('front.checkout')->with('error', 'Something went wrong.');
        } else {
            return redirect()->route('front.checkout')->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }

    public function handlePayPalSuccess($request)
    {
        $response = $this->paypal->capturePaymentOrder($request->query('token'));
        return $response;
    }

}
