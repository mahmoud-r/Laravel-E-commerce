<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderAdressRequest;
use App\Models\City;
use App\Models\Governorate;
use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\OrderHistory;
use App\Models\OrderPayment;
use App\Models\OrderStatue;
use App\Models\Shipment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use MongoDB\Driver\Session;
use Vinkla\Hashids\Facades\Hashids;

class OrderController extends Controller
{
    public function index(Request $request){
        $orders = Order::select('id','grand_total','created_at')->latest('created_at');

        if (!empty($request->keyword)){
            $orders= $orders->where('first_name','like','%'.$request->keyword.'%')
                ->orwhere('id','like','%'.$request->keyword.'%')
                ->orwhere('last_name','like','%'.$request->keyword.'%')
                ->orwhere('phone','like','%'.$request->keyword.'%');
        }

        $orders=  $orders->paginate(25);
        return view('admin.orders.index',compact('orders'));
    }

    public function orderView($order_id){
        $order = Order::findorfail($order_id);
        $governorates = Governorate::get();
        $cities = City::where('governorate_id',$order->address->governorate_id)->get();
        return view('admin.orders.view',compact('order','cities','governorates'));
    }

    public function shipmentUpdateStatus(Request $request, $shipment){
        $shipment = Shipment::find($shipment);
        $shipment->update(['status'=>$request->status]);
        return redirect(route('order.view',$request->order_id))->with('success','status of shipping Updated Successfully');
    }

    public function paymentUpdateStatus(Request $request, $payment){
        $payment = OrderPayment::find($payment);
        $payment->update(['status'=>$request->status,'paid_at'=>Carbon::now(),'order_id'=>$request->order_id]);
        return redirect(route('order.view',$request->order_id))->with('success','Payment confirmed Successfully');
    }
    public function OrderConfirm(Request $request){
        $order = Order::find($request->order_id);
        $order->status->update(['status'=>'processing']);
        return redirect(route('order.view',$request->order_id))->with('success','order confirmed Successfully');
    }
    public function updateOrderNote(Request $request){
        $order = Order::find($request->order_id);
        $order->status->update(['admin_note'=>$request->admin_note]);
        return redirect(route('order.view',$request->order_id))->with('success','Note Updated Successfully');
    }
    public function UpdateAddress(OrderAdressRequest $request,$address){
        $address = OrderAddress::find($address);
        $address->update([
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'city_id'=>$request->city_id,
            'street'=>$request->street,
            'phone'=>$request->phone,
            'second_phone'=>$request->second_phone,
            'building'=>$request->building,
            'district'=>$request->district,
            'governorate_id'=>$request->governorate_id,
            'nearest_landmark'=>$request->nearest_landmark,
        ]);
        session()->flash('success','Address Updated successfully.');
        return response()->json([
            'status' =>true,
            'msg' =>'Address Updated successfully.',
        ]);

    }

    public function orderCancel(Request $request){
        $order = Order::find($request->order_id);
        $order->status->update(['status' => 'cancelled']);
        $order->Shipment->update(['status' => 'Canceled']);
        return redirect(route('order.view',$request->order_id))->with('success','Order Canceled Successfully');
    }
    public function destroy(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if ($order->delete()) {
            return response()->json([
                'status' => true,
                'msg' => 'Order Deleted Successfully',
                'deleted_id' => $id
            ]);
        } else {
            return response()->json([
                'status' => false,
                'msg' => 'Something went wrong',
            ], 500);
        }


    }

}
