<?php

namespace App\Http\Controllers\admin\settings;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Governorate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CitesController extends Controller
{

    public function index(Request $request ,$governorate)
    {
        $cities = City::where('governorate_id',$governorate)->latest();
        $governorate = Governorate::select('governorate_name_en','id')->where('id',$governorate)->first();

        if (!empty($request->keyword)){
            $cities= $cities->where('city_name_en','like','%'.$request->keyword.'%')
                ->orwhere('city_name_ar','like','%'.$request->keyword.'%');
        }

        $cities=  $cities->paginate(25);

        return view('admin.shipping.cites.index',compact('cities','governorate'));
    }



    public function create($governorate)
    {
        $governorate = Governorate::select('governorate_name_en','id')->where('id',$governorate)->first();

        return view('admin.shipping.cites.create',compact('governorate'));
    }



    public function store(Request $request,$governorate_id)
    {
        $validator = Validator::make($request->all(),[
            'city_name_en' => 'required|unique:cities',
            'city_name_ar' => 'required|unique:cities',
        ]);

        if ($validator->fails()){
            return response()->json([
                'status' =>false,
                'errors' =>$validator->errors()
            ]);
        }
        $governorate = Governorate::find($governorate_id);

        if (!$governorate){
            return response()->json([
                'error' => 'Governorate not found',
                'status'=>false
            ]);
        }

        $city = $governorate->cities()->create([
            'city_name_en' => $request->city_name_en,
            'city_name_ar' => $request->city_name_ar,
        ]);

        $request->session()->flash('success','city added successfully');

        return response()->json([
            'status' =>true,
            'msg' =>'city added successfully'
        ]);
    }




    public function edit( $id)
    {
        $city = City::findOrFail($id);


        return view('admin.shipping.cites.edit',compact('city'));
    }


    public function update(Request $request,  $id)
    {
        $city = City::findOrFail($id);

        $validator = Validator::make($request->all(),[
            'city_name_en' => 'required|unique:cities,city_name_en,'.$city->id.'id',
            'city_name_ar' => 'required|unique:cities,city_name_ar,'.$city->id.'id',
        ]);

        if ($validator->fails()){
            return response()->json([
                'status' =>false,
                'errors' =>$validator->errors()
            ]);
        }

        $city->update([
            'city_name_en' => $request->city_name_en,
            'city_name_ar' => $request->city_name_ar,

        ]);


        $request->session()->flash('success','City updated successfully');

        return response()->json([
            'status' =>true,
            'msg' =>'City updated successfully'
        ]);
    }


    public function destroy(string $id)
    {
        $city = City::findOrFail($id);

        if ($city->delete()) {
            return response()->json([
                'status' => true,
                'msg' => 'City Deleted Successfully',
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
