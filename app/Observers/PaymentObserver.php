<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\OrderPayment;
use App\Models\OrderHistory;
use Illuminate\Support\Facades\Auth;

class PaymentObserver
{
    public function updated(OrderPayment $payment)
    {
        $adminId = Auth::guard('admin')->check() ? Auth::guard('admin')->id() : null;
        $adminName = Auth::guard('admin')->check() ? Auth::guard('admin')->name : 'System';

        if ($payment->isDirty('status')) {

            if ($payment->status == 'completed' ){
                $description = 'Payment was confirmed. by ' . $adminName . '.';
            }elseif ($payment->status == 'failed'){
                $description = 'Payment failed.';
            }else{
                $description = 'Payment status changed to: ' . $payment->status . '.';
            }

            OrderHistory::create([
                'action' => 'update_payment',
                'description' => $description,
                'admin_id' => $adminId,
                'order_id' => $payment->order_id
            ]);

            Order::checkOrderCompletion($payment->order_id);
        }
    }
}
