<?php

namespace App\Http\Controllers\admin\settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDiscountRequest;
use App\Http\Requests\UpdateDiscountRequest;
use App\Models\DiscountCoupon;
use Illuminate\Http\Request;

class DiscountCouponController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:discount-list|discount-create|discount-edit|discount-delete', ['only' => ['index'] ]);
        $this->middleware('permission:discount-create', ['only' => ['create','store']]);
        $this->middleware('permission:discount-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:discount-delete', ['only' => ['destroy']]);

    }
    public function index(Request $request)
    {
        $Coupons = DiscountCoupon::latest();

        if (! empty($request->get('keyword'))){

            $Coupons = $Coupons->where('name','like','%'.$request->get('keyword').'%')
            ->orwhere('code','like','%'.$request->get('keyword').'%');

        }

        $Coupons =$Coupons->paginate(25);
        return view('admin.discount.index',compact('Coupons'));
    }


    public function create()
    {
       return view('admin.discount.create');
    }


    public function store(StoreDiscountRequest $request)
    {
        $Coupon = DiscountCoupon::create([
            'code'=>$request->code,
            'name'=>$request->name,
            'description'=>$request->description,
            'max_uses'=>$request->max_uses,
            'max_uses_user'=>$request->max_uses_user,
            'type'=>$request->type,
            'discount_amount'=>$request->discount_amount,
            'min_amount'=>$request->min_amount,
            'status'=>$request->status,
            'starts_at'=>$request->starts_at,
            'expires_at'=>$request->expires_at,
        ]);
        $request->session()->flash('success','Coupon added successfully');

        return response()->json([
            'status' =>true,
            'msg' =>'Coupon added successfully'
        ]);
    }

    public function edit( $id)
    {
        $Coupon = DiscountCoupon::findOrFail($id);
        return view('admin.discount.edit',compact('Coupon'));

    }


    public function update(UpdateDiscountRequest $request,  $id)
    {
        $Coupon = DiscountCoupon::findOrFail($id);
        $Coupon->update([
            'code'=>$request->code,
            'name'=>$request->name,
            'description'=>$request->description,
            'max_uses'=>$request->max_uses,
            'max_uses_user'=>$request->max_uses_user,
            'type'=>$request->type,
            'discount_amount'=>$request->discount_amount,
            'min_amount'=>$request->min_amount,
            'status'=>$request->status,
            'starts_at'=>$request->starts_at,
            'expires_at'=>$request->expires_at,
        ]);
        $request->session()->flash('success','Coupon updated successfully');

        return response()->json([
            'status' =>true,
            'msg' =>'Coupon updated successfully'
        ]);
    }


    public function destroy( $id)
    {
        $Coupon = DiscountCoupon::findOrFail($id);

        if ($Coupon->delete()) {
            return response()->json([
                'status' => true,
                'msg' => 'Coupon Deleted Successfully',
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
