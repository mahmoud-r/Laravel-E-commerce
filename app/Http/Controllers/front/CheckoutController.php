<?php

namespace App\Http\Controllers\front;

use App\Events\NewOrder;
use App\Http\Controllers\Controller;
use App\Http\Traits\CartTrait;
use App\Http\Traits\CouponTrait;
use App\Models\DiscountCoupon;
use App\Models\Governorate;
use App\Models\Order;
use App\Models\Order_item;
use App\Models\OrderAddress;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Services\AddressService;
use App\Services\PaymentService;
use App\Services\ShippingService;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;



class CheckoutController extends Controller
{
    use CartTrait;
    use CouponTrait;

    protected PaymentService $paymentService;
    protected AddressService $addressService;
    protected ShippingService $shippingService;


    public function __construct(PaymentService $paymentService , AddressService $addressService, ShippingService $shippingService)
    {
        $this->paymentService = $paymentService;
        $this->addressService = $addressService;
        $this->shippingService = $shippingService;

    }


    public function index(){
        if (Cart::instance('default')->count() == 0){
            return redirect()->route('home')->with('error','Looks like your cart is empty. Keep shopping and fill it up!');
        }

        $governorates = Governorate::get();
        $validationCoupon = $this->validateCoupon();
        $cartUpdateStatus = $this->checkCartUpdates();

        $stripeSettings = PaymentMethod::getSettings('stripe');
        $paypalSettings = PaymentMethod::getSettings('paypal');
        $codSettings = PaymentMethod::getSettings('cod');
        $bankTransferSettings = PaymentMethod::getSettings('bank_transfer');

        return view('front.checkout',compact('governorates','stripeSettings','paypalSettings','codSettings','bankTransferSettings'));

    }


    //checkout process
    public function process_checkout(Request $request){

        //update cart
        if ($this->checkCartUpdates()['count'] < 1){
            return redirect()->back();
        }
        //check coupon
        if (Session::has('code')){
            $validateCoupon = $this->validateCoupon();

            //check coupon
            if ($validateCoupon['status'] == false){
                return redirect()->route('front.checkout')
                    ->with('error',$validateCoupon['msg'])
                    ->withInput();
            }
        }

        // save address
        try {
            $address = $request->has('address')
                ? $this->addressService->getAddress($request->address)
                : $this->addressService->validateAndCreateAddress($request);
        } catch (ValidationException $e) {
            return redirect()->route('front.checkout')
                ->withErrors($e->validator)
                ->withInput();
        }

        $order = $this->SaveOrder($request ,$address);

        switch ($request->payment_method) {
            case 'bank_transfer':
            case 'cod':
            try {
                event(new NewOrder($order));
            } catch (\Exception $e) {
                Log::error('Failed to send NewOrder event: ' . $e->getMessage());
            }
              return redirect()->route('front.orderCompleted', $order);
            case 'stripe':
                $checkoutUrl = $this->paymentService->processStripePayment($order);
                return redirect($checkoutUrl);
                case 'paypal':
                return $this->paymentService->processPayPalPayment($order);
            default:
                return redirect()->route('front.checkout')->with('error', 'Invalid payment method.');

        }

    }



    //Order Steps
    private function prepareOrderData($request, $address) {
        $shipping = 0;
        $discount = 0;
        $weight = 0;
        $coupon_code = '';
        $coupon_code_id = null;
        $subTotal = Cart::instance('default')->subtotal(2, '.', '');

        if (session()->has('code')) {
            $code = session()->get('code');
            $discount = ($code->type == 'percent')
                ? ($code->discount_amount / 100) * $subTotal
                : $code->discount_amount;
            $coupon_code = $code->code;
            $coupon_code_id = $code->id;
        }

        $governorateId = $address->governorate_id;
        $shipping =$this->shippingService->calculateShippingCost($governorateId, $this->shippingService->calculateWeight());
        $grandTotal = $shipping + ($subTotal - $discount);
        $grandTotal = makeNonNegative($grandTotal);

        return [
            'user_id' => auth()->user()->id,
            'subtotal' => $subTotal,
            'shipping' => $shipping,
            'discount' => $discount,
            'coupon_code' => $coupon_code,
            'coupon_code_id' => $coupon_code_id,
            'grand_total' => $grandTotal,
            'payment_method' => $request->payment_method,
            'note' => $request->note,
        ];
    }
    private function saveOrderItems($order) {
        foreach (Cart::instance('default')->content() as $item) {
            Order_item::create([
                'order_id' => $order->id,
                'product_id' => $item->id,
                'name' => $item->name,
                'qty' => $item->qty,
                'price' => $item->price,
                'total' => $item->total
            ]);
        }
    }
    private function saveOrderAddress($address,$order) {
            OrderAddress::create([
                'order_id' => $order->id,
                'first_name' => $address->first_name,
                'last_name' => $address->last_name,
                'street' => $address->street,
                'building' => $address->building,
                'city_id' => $address->city_id,
                'district' => $address->district,
                'governorate_id' => $address->governorate_id,
                'nearest_landmark' => $address->nearest_landmark,
                'phone' => $address->phone,
                'second_phone' => $address->second_phone,
            ]);
        }
    private function SaveOrder($request, $address){
        //save order
        $orderData = $this->prepareOrderData($request, $address);
        $weight =$this->shippingService->calculateWeight();

        DB::beginTransaction();
        try{
            $order = Order::create($orderData);
            $this->saveOrderItems($order);
            $this->saveOrderAddress($address,$order);
            $order->History()->create(['status'=>'pending','action'=>'create_order','description'=>'Order is created from the checkout page','user_id'=>Auth::user()->id]);
            $order->status()->create(['status'=>'pending']);
            $order->Payment()->create(['status'=>'pending']);
            $order->Shipment()->create(['user_id'=>auth()->id(),'weight'=>$weight,'price'=>$orderData['shipping']]);
            DB::commit();

            Cart::instance('default')->destroy();
            session()->forget('code');

            return $order;

        }catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('front.checkout')
                ->with('error',$e->getMessage())
                ->withInput();
        }
    }



    //Thank you Page
    public function orderCompleted($order){
        $order = Order::getId($order);
        $order = Order::find($order);
        if (!$order || $order->user->id != Auth::user()->id) {
            throw new NotFoundHttpException();
        }
        return view('front.order-completed',compact('order'));
    }


    //Discount
    public function applyDiscount(Request $request) {
        $code = DiscountCoupon::where('code', $request->code)->first();

        if ($code == null) {
            return response()->json([
                'status' => false,
                'msg' => 'Invalid discount coupon.'
            ]);
        }

        if ($code->status == 0) {
            return response()->json([
                'status' => false,
                'msg' => 'Invalid discount coupon.'
            ]);
        }

        $now = Carbon::now();

        if (!empty($code->starts_at)) {
            $startDate = Carbon::createFromFormat('Y-m-d H:i:s', $code->starts_at);
            if ($now->lt($startDate)) {
                return response()->json([
                    'status' => false,
                    'msg' => 'Discount coupon is not valid yet.'
                ]);
            }
        }

        if (!empty($code->expires_at)) {
            $endDate = Carbon::createFromFormat('Y-m-d H:i:s', $code->expires_at);
            if ($now->gt($endDate)) {
                return response()->json([
                    'status' => false,
                    'msg' => 'Discount coupon has expired.'
                ]);
            }
        }

        if ($code->max_uses > 0) {
            $couponUsed = Order::where('coupon_code_id', $code->id)->count();
            if ($couponUsed >= $code->max_uses) {
                return response()->json([
                    'status' => false,
                    'msg' => 'Discount coupon has reached its maximum uses.'
                ]);
            }
        }

        if ($code->max_uses_user > 0) {
            $couponUsedByUser = Order::where(['coupon_code_id' => $code->id, 'user_id' => Auth::id()])->count();
            if ($couponUsedByUser >= $code->max_uses_user) {
                return response()->json([
                    'status' => false,
                    'msg' => 'You have already used this coupon.'
                ]);
            }
        }

        $subTotal = Cart::instance('default')->subtotal(2, '.', '');

        if ($code->min_amount > 0 && $subTotal < $code->min_amount) {
            return response()->json([
                'status' => false,
                'msg' => 'Minimum amount must be $' . $code->min_amount
            ]);
        }

        session()->put('code', $code);

        return $this->getOrderSummery($request);
    }

    public function removeCoupon(Request $request){
        session()->forget('code');
        return $this->getOrderSummery($request);
    }

    //OrderSummery
    public function getOrderSummery(Request $request){

        $weight = $this->shippingService->calculateWeight();
        $governorateId =$request->governorateId;
        $subtotal = Cart::instance('default')->subtotal(2,'.','');
        $discount = 0;
        $discountString='';

        //apply discount
        if (session()->has('code')){
            $code =session()->get('code');
            if ($code->type == 'percent'){
                $discount = ($code->discount_amount/100)*$subtotal;
            }else{
                $discount=$code->discount_amount;
            }
            $discountString = '<div class="coupon field_form input-group mt-1" >
                                    <strong class="text-primary">'.session()->get('code')->code.'</strong>
                                    <a href="javascript:void(0)" onclick="RemoveCoupon()"  class=""><i class="ti-close  text-black" style="font-size: 11px;margin-left: 5px"></i> </a>
                                </div>';
        }



        $total_shipping = $this->shippingService->calculateShippingCost($governorateId, $weight);


        $grand_total  =$total_shipping +($subtotal-$discount);

        return response()->json([
            'status' =>true,
            'total_shipping'=>number_format($total_shipping,2),
            'discount'=>number_format($discount,2),
            'discountString'=>$discountString,
            'grand_total'=>makeNonNegative(number_format($grand_total,2))
        ]);
    }


    //payment
    //Stripe
    public function paymentSuccess(Request $request)
    {
        $session_id = $request->query('session_id');
        $order_id = Order::getId($request->order);
        $order = Order::find($order_id);

        if (!$session_id || !$order) {
            return redirect()->route('front.checkout')->with('error', 'Invalid session or order ID');
        }

        try {
            $order = $this->paymentService->handleStripeSuccess($session_id, $order, Auth::user()->id);
            return redirect()->route('front.orderCompleted', $order);
        } catch (\Exception $e) {
            return redirect()->route('front.checkout')->with('error', $e->getMessage());
        }
    }

    public function paymentCancel(Request $request)

    {
        $order = Order::getId($request->order);
        $order = Order::find($order);

        try {
            event(new NewOrder($order));
        } catch (\Exception $e) {
            Log::error('Failed to send NewOrder event: ' . $e->getMessage());
        }

        return redirect()->route('front.showOrder',$order)->with('error', 'Payment was canceled.');
    }


    //Paypal
    public function paymentPayPalSuccess(Request $request)
    {
        $response = $this->paymentService->handlePayPalSuccess($request);

        $order = Order::getId($request->order);
        $order = Order::find($order);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {

            $order->payment->update(['status' => 'completed']);

            try {
                event(new NewOrder($order));
            } catch (\Exception $e) {
                Log::error('Failed to send NewOrder event: ' . $e->getMessage());
            }

            return redirect()->route('front.orderCompleted', $order);
        } else {
            return $this->paymentPayPalCancel($request);
        }
    }

    public function paymentPayPalCancel(Request $request)
    {
        $order = Order::getId($request->order);
        $order = Order::find($order);

        $order->payment->update(['status' => 'failed']);
        try {
            event(new NewOrder($order));
        } catch (\Exception $e) {
            Log::error('Failed to send NewOrder event: ' . $e->getMessage());
        }

        return redirect()->route('front.showOrder',$order)->with('error', 'Payment failed.');
    }




}
