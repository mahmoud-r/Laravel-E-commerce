<?php


namespace App\Observers;

use App\Models\Order;
use App\Models\OrderHistory;
use Illuminate\Support\Facades\Auth;

class OrderObserver
{

    public function deleting(Order $order)
    {
        if ($order->isForceDeleting()) {
            // If the order is being force deleted, force delete related records
            $order->items()->forceDelete();
            $order->Payment()->forceDelete();
            $order->status()->forceDelete();
            $order->address()->forceDelete();
            $order->Shipment()->forceDelete();
        } else {
            // If the order is being soft deleted, soft delete related records
            $order->items()->delete();
            $order->Payment()->delete();
            $order->status()->delete();
            $order->address()->delete();
            $order->Shipment()->delete();

            $adminId = Auth::guard('admin')->check() ? Auth::guard('admin')->id() : null;
            $adminName = Auth::guard('admin')->check() ? Auth::guard('admin')->name : 'System';
            $description = 'Order was Deleted by '.$adminName.'.';
            OrderHistory::create([
                'action' => 'order_Deleted',
                'description' => $description,
                'admin_id' => $adminId,
                'order_id' => $order->id,
            ]);
        }
    }
    public function restoring(Order $order)
    {
        // Restore related records when the order is being restored
        $order->items()->withTrashed()->restore();
        $order->Payment()->withTrashed()->restore();
        $order->status()->withTrashed()->restore();
        $order->address()->withTrashed()->restore();
        $order->Shipment()->withTrashed()->restore();

        $adminId = Auth::guard('admin')->check() ? Auth::guard('admin')->id() : null;
        $adminName = Auth::guard('admin')->check() ? Auth::guard('admin')->name : 'System';
        $description = 'Order was restoring by '.$adminName.'.';
        OrderHistory::create([
            'action' => 'order_restoring',
            'description' => $description,
            'admin_id' => $adminId,
            'order_id' => $order->id,
        ]);
    }
}


