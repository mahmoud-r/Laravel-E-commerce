<?php

namespace App\Observers;

use App\Models\ShipmentInfo;
use App\Models\OrderHistory;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ShipmentInfoObserver
{
    public function updated(ShipmentInfo $shipmentInfo)
    {
        $adminId = Auth::guard('admin')->check() ? Auth::guard('admin')->id() : null;
        $adminName = Auth::guard('admin')->check() ? Auth::guard('admin')->user()->name : 'System';

        $description = 'Shipment info Updated  by ' . $adminName;
        $shipmentInfo->shipment->history()->create([
            'action' => 'update_shipment',
            'description' => $description,
            'admin_id' => $adminId,
            'order_id' => $shipmentInfo->shipment->order_id
        ]);

        OrderHistory::create([
            'action' => 'update_shipment',
            'description' => $description,
            'admin_id' => $adminId,
            'order_id' => $shipmentInfo->shipment->order_id
        ]);
    }

    public function created(ShipmentInfo $shipmentInfo)
    {
        $orderLink = '<a href="' . route('order.view', $shipmentInfo->shipment->order->id) . '">' . $shipmentInfo->shipment->order->order_number . '</a>';
        $shipmentLink = '<a href="' . route('shipment.view', $shipmentInfo->shipment->id) . '">' . $shipmentInfo->shipment->shipment_number . '</a>';
        $descriptionShipment = 'Shipment info Updated for order : ' . $orderLink;
        $descriptionOrder = 'Shipment info Updated ' . $shipmentLink;

        $shipmentInfo->shipment->history()->create([
            'action' => 'create_shipment',
            'description' => $descriptionShipment,
            'order_id' => $shipmentInfo->shipment->order_id
        ]);

        OrderHistory::create([
            'action' => 'create_shipment',
            'description' => $descriptionOrder,
            'order_id' => $shipmentInfo->shipment->order_id
        ]);
    }
}
