<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdressRequest;
use App\Http\Requests\UpdateAdressRequest;
use App\Models\City;
use App\Models\Governorate;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserAddressController extends Controller
{

    public function index()
    {
        //
    }


    public function create()
    {
        //
    }


    public function store(StoreAdressRequest $request)
    {

        if ($request->is_primary) {
            auth()->user()->addresses()->update(['is_primary' => false]);
        }

        $address = auth()->user()->addresses()->create($request->validated());

        $addresses =  auth()->user()->addresses()->get();
        return response()->json([
            'status' =>true,
            'view' => view('front.profile.addresses.addresses_box',compact('addresses'))->render(),
            'msg' =>'Address added successfully.',
            'address'=>$address,
            'city'=>$address->city->city_name_en,
            'governorate'=>$address->governorate->governorate_name_en

        ]);
    }


    public function show(string $id)
    {
        //
    }


    public function edit( $id)
    {
        $address = UserAddress::where('user_id', auth()->id())->where('id', $id)->first();
        $governorates = Governorate::get();
        $cities = City::where('governorate_id',$address->governorate_id)->get();
        return view('front.profile.addresses.edit_model',compact('address','governorates','cities'))->render();
    }


    public function update(UpdateAdressRequest $request,  $id)
    {
        $address = UserAddress::where('user_id', auth()->id())->where('id', $id)->first();

            if ($request->input('is_primary') == 1) {
                auth()->user()->addresses()->update(['is_primary' => false]);
                $address->is_primary = true;
            } else {
                $address->is_primary = false;
            }

        $address->update($request->except('is_primary'));

        $addresses =  auth()->user()->addresses()->get();
        return response()->json([
            'status' =>true,
            'view' => view('front.profile.addresses.addresses_box',compact('addresses'))->render(),
            'msg' =>'Address Updated successfully.',
            'address'=>$address,
            'city'=>$address->city->city_name_en,
            'governorate'=>$address->governorate->governorate_name_en
        ]);
    }


    public function destroy(string $id)
    {
        $address = UserAddress::where('user_id', auth()->id())->where('id', $id)->first();


        if ($address->delete()) {
            return response()->json([
                'status' => true,
                'msg' => 'Address Deleted Successfully',
                'deleted_id' => $id
            ]);
        } else {
            return response()->json([
                'status' => false,
                'msg' => 'Something went wrong',
            ], 500);
        }
    }


    public function getaddress($id){
        $address = UserAddress::where('user_id', auth()->id())->where('id', $id)->first();
        return view('front.profile.addresses.box',compact('address'));
    }


    public function getCities(Request $request){

        if (!empty($request->governorate_id)){

        $cities = City::select('city_name_en','id')->where('governorate_id',$request->governorate_id)
            ->orderBy('city_name_en','ASC')
            ->get();

        return response()->json([
            'status'=>true,
            'cities'=>$cities
        ]);
    }else{
            return response()->json([
                'status'=>true,
                'cities'=>[]
            ]);
        }
    }
}
