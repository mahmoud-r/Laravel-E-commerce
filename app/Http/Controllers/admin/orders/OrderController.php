<?php

namespace App\Http\Controllers\admin\orders;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderAdressRequest;
use App\Models\City;
use App\Models\Governorate;
use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\OrderPayment;
use App\Models\Shipment;
use App\Notifications\user\OrderConfirmationNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class OrderController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:order-list|order-payment-confirm|order-confirm|order-delete|order-cancel|order-update-shipping-information|order-update-shipping-status|order-update-note', ['only' => ['index','getAll','orderView'] ]);
        $this->middleware('permission:order-confirm', ['only' => ['OrderConfirm']]);
        $this->middleware('permission:order-cancel', ['only' => ['orderCancel']]);
        $this->middleware('permission:order-payment-confirm', ['only' => ['paymentUpdateStatus']]);
        $this->middleware('permission:order-update-shipping-information', ['only' => ['UpdateAddress']]);
        $this->middleware('permission:order-update-shipping-status', ['only' => ['shipmentUpdateStatus']]);
        $this->middleware('permission:order-update-note', ['only' => ['updateOrderNote']]);
        $this->middleware('permission:order-delete', ['only' => ['destroy']]);

    }
    public function index(){

        return view('admin.orders.index');
    }

    public function getAll() {
        $orders = Order::latest()
            ->with(['status', 'user','payment'])
            ->get()
            ->map(function($order) {
                return [
                    'id' => $order->id,
                    'index' => $order->index,
                    'user' => [
                        'id' => $order->user->id,
                        'name' => $order->user->name,
                    ],
                    'phone'=>$order->address->phone,
                    'payment_status'=>$order->payment->status,
                    'status' => $order->status->status,
                    'total' => $order->grand_total,
                    'date' => $order->created_at,
                    'order_number' => $order->order_number,
                ];
            });

        return response()->json($orders);
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

         // Check user notification setting
        if (config('settings.email_user_confirm_order')) {
            Notification::send($order->user, new OrderConfirmationNotification($order));
        }
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
