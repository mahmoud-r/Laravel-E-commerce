<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Http\Traits\CartTrait;
use App\Http\Traits\CouponTrait;
use App\Http\Traits\ShippingTrait;
use App\Models\DiscountCoupon;
use App\Models\Governorate;
use App\Models\Order;
use App\Models\Order_item;
use App\Models\OrderAddress;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\UserAddress;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    use CartTrait;
    use ShippingTrait;
    use CouponTrait;

    public function index(){


        if (Cart::instance('default')->count() == 0){
            return redirect()->route('home')->with('error','Looks like your cart is empty. Keep shopping and fill it up!');
        }

        $governorates = Governorate::get();
        $validationCoupon = $this->validateCoupon();
        $cartUpdateStatus = $this->checkCartUpdates();

        if ($cartUpdateStatus['updated']) {
            session()->flash('info', $cartUpdateStatus['msg']);
        }


        $stripeSettings = PaymentMethod::getSettings('stripe');
        $paypalSettings = PaymentMethod::getSettings('paypal');
        $codSettings = PaymentMethod::getSettings('cod');
        $bankTransferSettings = PaymentMethod::getSettings('bank_transfer');

        return view('front.checkout',compact('governorates','stripeSettings','paypalSettings','codSettings','bankTransferSettings'));

    }

    public function process_checkout(Request $request){

        //update cart
        $this->checkCartUpdates();
        //check coupon
        $this->validateCoupon();


        // save address
        try {
            $address = $request->has('address')
                ? $this->getAddress($request->address)
                : $this->validateAndCreateAddress($request);
        } catch (ValidationException $e) {
            return redirect()->route('front.checkout')
                ->withErrors($e->validator)
                ->withInput();
        } catch (ModelNotFoundException $e) {
            return redirect()->route('front.checkout')
                ->withErrors(['address' => 'Selected address not found.'])
                ->withInput();
        }


        //save order
        if ($request->payment_method == 'cod' || $request->payment_method == 'bank_transfer') {
            $orderData = $this->prepareOrderData($request, $address);
            $weight =$this->calculateWeight();
            $order =  DB::transaction(function () use ($orderData,$address,$weight) {
                $order = Order::create($orderData);
                $this->saveOrderItems($order);
                $this->saveOrderAddress($address,$order);
                $order->History()->create(['status'=>'pending','action'=>'create_order','description'=>'Order is created from the checkout page','user_id'=>Auth::user()->id]);
                $order->status()->create(['status'=>'pending']);
                $order->Payment()->create(['status'=>'pending']);
                $order->Shipment()->create(['user_id'=>auth()->id(),'weight'=>$weight,'price'=>$orderData['shipping']]);

                return $order;
            });


            Cart::instance('default')->destroy();
            session()->forget('code');

            return redirect()->route('front.orderCompleted', $order);
        }


    }


    public function orderCompleted($order){
        $order = Order::getId($order);
        $order =  Order::where(['user_id'=>auth()->user()->id,'id'=>$order])->first();
        if (!$order){
            abort(404);
        }
        return view('front.order-completed',compact('order'));
    }

    public function getOrderSummery(Request $request){
        $weight = 0;
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


        foreach (Cart::instance('default')->content() as $item){
            $product =Product::select('weight')->where('id',$item->id)->first();
            $weight +=$product-> weight * $item->qty;
        }
        $total_shipping = $this->calculateShippingCost($governorateId, $weight);


        $grand_total  =$total_shipping +($subtotal-$discount);

        return response()->json([
            'status' =>true,
            'total_shipping'=>number_format($total_shipping,2),
            'discount'=>number_format($discount,2),
            'discountString'=>$discountString,
            'grand_total'=>makeNonNegative(number_format($grand_total,2))
        ]);
    }

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


    private function validateAndCreateAddress($request) {
        $validator = Validator::make($request->all(), [
            'address_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'building' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
            'district' => 'nullable|string|max:255',
            'governorate_id' => 'required|exists:governorates,id',
            'nearest_landmark' => 'nullable|string|max:255',
            'phone' => 'required|phone:EG',
            'second_phone' => 'nullable|phone:EG',
            'is_primary' => 'boolean'
        ], [
            'phone.phone' => 'The phone number must be a valid EG phone number.',
            'second_phone.phone' => 'The phone number must be a valid EG phone number.'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return auth()->user()->addresses()->create($request->all());
    }
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
        $shipping = $this->calculateShippingCost($governorateId, $this->calculateWeight());
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

    private function calculateWeight() {
        $weight = 0;
        foreach (Cart::instance('default')->content() as $item) {
            $product = Product::select('weight')->where('id', $item->id)->first();
            $weight += $product->weight * $item->qty;
        }
        return $weight;
    }
    private function getAddress($addressId)
    {
        return UserAddress::where('user_id', auth()->id())->where('id', $addressId)->firstOrFail();
    }
}
