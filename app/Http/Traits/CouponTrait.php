<?php

namespace App\Http\Traits;

use App\Models\DiscountCoupon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use Carbon\Carbon;

trait CouponTrait
{
    public function validateCoupon()
    {
        if (!Session::has('code')) {
            return ['status' => false, 'msg' => 'No coupon applied.'];
        }

        $codeRequest = Session::get('code');
        $code = DiscountCoupon::find($codeRequest->id);

        $now = Carbon::now();

        if (!$code){
            Session::forget('code');
            return ['status' => false, 'msg' => 'Discount coupon has expired.'];
        }
        if ($code->status == 0) {
            Session::forget('code');
            return ['status' => false, 'msg' => 'Invalid discount Coupon.'];
        }

        if (!empty($code->starts_at)) {
            $startDate = Carbon::createFromFormat('Y-m-d H:i:s', $code->starts_at);

            if ($now->lt($startDate)) {
                Session::forget('code');
                return ['status' => false, 'msg' => 'Discount coupon is not valid.'];
            }
        }

        if (!empty($code->expires_at)) {
            $endDate = Carbon::createFromFormat('Y-m-d H:i:s', $code->expires_at);

            if ($now->gt($endDate)) {
                Session::forget('code');
                return ['status' => false, 'msg' => 'Discount coupon has expired.'];
            }
        }

        if ($code->max_uses > 0) {
            $couponUsed = Order::where('coupon_code_id', $code->id)->count();

            if ($couponUsed >= $code->max_uses) {
                Session::forget('code');
                return ['status' => false, 'msg' => 'Discount coupon has expired.'];
            }
        }

        if ($code->max_uses_user > 0) {
            $couponUsedByUser = Order::where(['coupon_code_id' => $code->id, 'user_id' => Auth::id()])->count();

            if ($couponUsedByUser >= $code->max_uses_user) {
                Session::forget('code');
                return ['status' => false, 'msg' => 'You already used this coupon.'];
            }
        }

        $subTotal = Cart::subtotal(2, '.', '');

        if ($code->min_amount > 0 && $subTotal < $code->min_amount) {
            Session::forget('code');
            return ['status' => false, 'msg' => 'The minimum amount must be $' . $code->min_amount];
        }


        return ['status' => true];
    }
}
