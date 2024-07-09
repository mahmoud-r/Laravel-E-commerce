<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class webhookController extends Controller
{
     //webhook Test
    public function handel(){

        $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));

        $endpoint_secret = config('services.stripe.webhook_secret');

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];

        Log::info('Webhook received');
        Log::info('Payload: ' . $payload);
        Log::info('Signature Header: ' . $sig_header);

        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );

            Log::info('Event constructed successfully');
        } catch(\UnexpectedValueException $e) {
            Log::error('Invalid payload: ' . $e->getMessage());
            // Invalid payload
            return response('',400);
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            Log::error('Invalid signature: ' . $e->getMessage());
            // Invalid signature
            return response('',400);
        }

        // Handle the event
        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;
                $sessionId =$session->id;

                $order =Order::where('stripe_session_id',$sessionId)->first();

                if (!$order){
                    throw new NotFoundHttpException();
                }

                if ($order->payment->status !='completed'){

                    $order->payment->update(['status'=>'completed']);

                }

            default:
                Log::info('Received unknown event type ' . $event->type);
                echo 'Received unknown event type ' . $event->type;
        }

        return response('',200);
    }

    //webhook Live
//    public function handel(){
//
//        $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
//        $endpoint_secret = config('services.stripe.webhook_secret');
//        $payload = @file_get_contents('php://input');
//        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
//        $event = null;
//
//        try {
//            $event = \Stripe\Webhook::constructEvent(
//                $payload, $sig_header, $endpoint_secret
//            );
//        } catch (\UnexpectedValueException $e) {
//            // Invalid payload
//            http_response_code(400);
//            exit();
//        } catch (\Stripe\Exception\SignatureVerificationException $e) {
//            // Invalid signature
//            http_response_code(400);
//            exit();
//        }
//
//        // Handle the event
//        switch ($event->type) {
//            case 'checkout.session.completed':
//                $session = $event->data->object;
//                $sessionId =$session->id;
//
//                $order =Order::where('stripe_session_id',$sessionId)->first();
//
//                if (!$order){
//                    throw new NotFoundHttpException();
//                }
//
//                if ($order->payment->status !='completed'){
//
//                    $order->payment->update(['status'=>'completed']);
//
//                }
//
//            default:
//                Log::info('Received unknown event type ' . $event->type);
//                echo 'Received unknown event type ' . $event->type;
//        }
//
//
//        http_response_code(200);
//        }

}
