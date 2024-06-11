<?php

namespace App\Observers;

use App\Models\OrderStatue;
use App\Models\OrderHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class OrderStatusObserver
{
    public function updated(OrderStatue $orderStatus)
    {
        $adminId = Auth::guard('admin')->check() ? Auth::guard('admin')->id() : null;
        $adminName = Auth::guard('admin')->check() ? Auth::guard('admin')->name : 'System';

        if ($orderStatus->isDirty('status')) {
            if ($orderStatus->status == 'processing'){
                $description = 'Order was verified by '.$adminName.'.';

            }else{
                $description = 'Order status changed to: ' . $orderStatus->status . ' by '.$adminName.'.';
            }

            OrderHistory::create([
                'action' => 'update_order_status',
                'description' => $description,
                'admin_id' => $adminId,
                'order_id' => $orderStatus->order_id,
            ]);
        }
        if ($orderStatus->isDirty('admin_note')) {
            $description = 'Order Note Updated to: ' . $orderStatus->admin_note . ' by '.$adminName.'.';
            OrderHistory::create([
                'action' => 'update_order_note',
                'description' => $description,
                'admin_id' => $adminId,
                'order_id' => $orderStatus->order_id,
            ]);
        }

    }

}
