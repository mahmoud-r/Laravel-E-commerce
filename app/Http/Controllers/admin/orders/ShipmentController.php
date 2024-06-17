<?php

namespace App\Http\Controllers\admin\orders;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShipmentInfoRequest;
use App\Models\Shipment;
use App\Models\ShipmentInfo;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{

        public function index(){

            return view('admin.shipments.index');
        }

        public function getAll() {
        $Shipments = Shipment::latest()
            ->with(['order'])
            ->get()
            ->map(function($Shipment) {
                return [
                    'id' => $Shipment->id,
                    'index' => $Shipment->index,
                    'user' => [
                        'id' => $Shipment->user->id,
                        'name' => $Shipment->user->name,
                    ],
                    'status' => $Shipment->status,
                    'price' => $Shipment->price,
                    'date' => $Shipment->created_at,
                    'order_number' => $Shipment->order->order_number,
                    'shipment_number' => $Shipment->shipment_number,
                ];
            });

        return response()->json($Shipments);
    }

        public function shipmentView($shipment){
            $shipment =Shipment::findOrFail($shipment);
            return view('admin/shipments/view',compact('shipment'));
        }

        public function shipmentUpdateStatus(Request $request, $shipment){
            $shipment = Shipment::find($shipment);
            $shipment->update(['status'=>$request->status]);
            return redirect(route('shipment.view',$shipment))->with('success','status of shipping Updated Successfully');
        }
        public function shipmentUpdateInfo(ShipmentInfoRequest  $request,$shipment){

            $shipment = Shipment::findOrFail($shipment);
            ShipmentInfo::updateOrCreate(['shipment_id' => $shipment->id],[
                'shipment_id' => $shipment->id,
                'shipping_company_name' => $request->shipping_company_name,
                'tracking_id' => $request->tracking_id,
                'note' => $request->note,
                'tracking_link' => $request->tracking_link,
                'estimate_date_shipped' => $request->estimate_date_shipped
            ]);

            return response()->json([
                'status' => true,
                'msg'=>'shipment information Updated Successfully',

            ]);

        }
}
