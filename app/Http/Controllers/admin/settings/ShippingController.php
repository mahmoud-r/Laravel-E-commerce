<?php

namespace App\Http\Controllers\admin\settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreShippingRequest;
use App\Http\Requests\UpdateShippingRequest;
use App\Models\Governorate;
use App\Models\ShippingZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShippingController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:shipping-list|shipping-create|shipping-edit|shipping-delete', ['only' => ['index'] ]);
        $this->middleware('permission:shipping-create', ['only' => ['create','store']]);
        $this->middleware('permission:shipping-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:shipping-delete', ['only' => ['destroy']]);

    }
    public function index(){

        $zones = ShippingZone::get();
        return view('admin.shipping.index',compact('zones'));

    }
    public function create(){

        $usedGovernorateIds = DB::table('governorate_shipping_zones')->pluck('governorate_id');
        $governorates = Governorate::whereNotIn('id', $usedGovernorateIds)->orderBy('governorate_name_en', 'ASC')->get();


        return view('admin.shipping.create',compact('governorates'));
    }


    public function edit($id){
        $zone = ShippingZone::findOrFail($id);

        $usedGovernorateIds = DB::table('governorate_shipping_zones')->pluck('governorate_id');
        $governorates = Governorate::whereNotIn('id', $usedGovernorateIds)->orderBy('governorate_name_en', 'ASC')->get();
        return view('admin.shipping.edit',compact('zone','governorates'));

    }

    public function update(UpdateShippingRequest $request ,$id){

        $zone = ShippingZone::findOrFail($id);

        DB::transaction(function () use ($request,$zone) {

            $zone->update([
            'name' => $request->name,
            'additional_weight_price' => $request->additional_weight_price,
            'weight_to' => $request->weight_to,
            'price' => $request->price,
            'delivery_time' => $request->delivery_time,
        ]);
        $zone->governorates()->sync($request->governorates);

        });
        Session()->flash('success','Shipping Zone Updated Successfully');

        return response()->json([
            'status' => true,
            'msg'=>'Shipping Zone Updated Successfully'
        ]);
    }
    public function store(StoreShippingRequest $request){

        DB::transaction(function () use ($request) {
            $zone = ShippingZone::create([
                'name' => $request->name,
                'additional_weight_price' => $request->additional_weight_price,
                'weight_to' => $request->weight_to,
                'price' => $request->price,
                'delivery_time' => $request->delivery_time,
            ]);

            $zone->governorates()->sync($request->governorates);
        });
        Session()->flash('success','Shipping Zone Created Successfully');

        return response()->json([
            'status' => true,
            'msg'=>'Shipping Zone Created Successfully'
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $zone = ShippingZone::findOrFail($id);

        if ($zone->delete()) {
            return response()->json([
                'status' => true,
                'msg' => 'zone Deleted Successfully',
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
