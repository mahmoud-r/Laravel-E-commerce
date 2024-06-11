<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\Shipment;
use App\Models\OrderHistory;
use Illuminate\Support\Facades\Auth;

class ShipmentObserver
{
    public function updated(Shipment $shipment)
    {
        $adminId = Auth::guard('admin')->check() ? Auth::guard('admin')->id() : null;
        $adminName = Auth::guard('admin')->check() ? Auth::guard('admin')->name : 'System';

        if ($shipment->isDirty('status')) {
            $description = 'Shipment status changed to: ' . $shipment->status . '. by '.$adminName;
            $shipment->history()->create([
                'action' => 'update_shipment',
                'description' => $description,
                'admin_id' => $adminId,
                'order_id' => $shipment->order_id
            ]);

            OrderHistory::create([
                'action' => 'update_shipment',
                'description' => $description,
                'admin_id' => $adminId,
                'order_id' => $shipment->order_id
            ]);

            Order::checkOrderCompletion($shipment->order_id);
        }
    }

        public function created(Shipment $shipment){
            $order_link = '<a href="'.route('order.view',$shipment->order->id).'">'.$shipment->order->order_number.'</a>';
            $shipment_link = '<a href="'.route('shipment.view',$shipment->id).'">'.$shipment->shipment_number.'</a>';
            $description_shipment = 'Shipping was created from order : '.$shipment_link;
            $description_order = 'Shipping was created '.$order_link;

            $shipment->history()->create([
                'action' => 'create_shipment',
                'description' => $description_shipment,
                'order_id' => $shipment->order_id
            ]);

            OrderHistory::create([
                'action' => 'create_shipment',
                'description' => $description_order,
                'order_id' => $shipment->order_id
            ]);
        }




}
