<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Governorate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GovernorateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $governorates = Governorate::latest();

        if (!empty($request->keyword)){
            $governorates= $governorates->where('governorate_name_en','like','%'.$request->keyword.'%')
                ->orwhere('governorate_name_ar','like','%'.$request->keyword.'%');
        }

        $governorates=  $governorates->paginate(15);
        return view('admin.shipping.governorate.index',compact('governorates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.shipping.governorate.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'governorate_name_en' => 'required|unique:governorates',
            'governorate_name_ar' => 'required|unique:governorates',
        ]);

            if ($validator->fails()){
                return response()->json([
                    'status' =>false,
                    'errors' =>$validator->errors()
                ]);
            }
        $governorate = Governorate::create([
            'governorate_name_en' => $request->governorate_name_en,
            'governorate_name_ar' => $request->governorate_name_ar,

        ]);


        $request->session()->flash('success','Governorate added successfully');

        return response()->json([
            'status' =>true,
            'msg' =>'Governorate added successfully'
        ]);
    }

    public function edit( $id)
    {
        $governorate = Governorate::findOrFail($id);


        return view('admin.shipping.governorate.edit',compact('governorate'));
    }


    public function update(Request $request,  $id)
    {
        $governorate = Governorate::findOrFail($id);

        $validator = Validator::make($request->all(),[
            'governorate_name_en' => 'required|unique:governorates,governorate_name_en,'.$governorate->id.'id',
            'governorate_name_ar' => 'required|unique:governorates,governorate_name_ar,'.$governorate->id.'id',
        ]);

        if ($validator->fails()){
            return response()->json([
                'status' =>false,
                'errors' =>$validator->errors()
            ]);
        }

        $governorate->update([
            'governorate_name_en' => $request->governorate_name_en,
            'governorate_name_ar' => $request->governorate_name_ar,

        ]);


        $request->session()->flash('success','Governorate updated successfully');

        return response()->json([
            'status' =>true,
            'msg' =>'Governorate updated successfully'
        ]);
    }


    public function destroy( $id)
    {
        $governorate = Governorate::findOrFail($id);

        if ($governorate->delete()) {
            return response()->json([
                'status' => true,
                'msg' => 'Governorate Deleted Successfully',
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
