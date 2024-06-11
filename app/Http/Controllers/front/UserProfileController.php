<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Governorate;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{
    public function index(){

        return view('front.profile.profile');
    }

    public function orders(){
        $orders =  Order::where('user_id',auth()->user()->id)->orderBy('created_at','DESC')->get();

        return view('front.profile.orders.orders',compact('orders'));
    }
    public function address(){
        $addresses =  auth()->user()->addresses()->get();
        $governorates = Governorate::get();
        return view('front.profile.addresses.address',compact('addresses','governorates'));
    }
    public function reviews(){
        $reviews =  auth()->user()->ratings()->get();
        return view('front.profile.reviews',compact('reviews'));
    }
    public function accountDetail(){
        return view('front.profile.details.details');
    }
    public function changePasswordForm(){
        return view('front.profile.details.password');
    }

    public function showOrder($order){
        $order = Order::getId($order);
        $order =  Order::where(['user_id'=>auth()->user()->id,'id'=>$order])->first();
        if (!$order){
            abort(404);
        }

        return view('front.profile.orders.view',compact('order'));
    }

    public function changePassword(Request $request) {
        $request->validate([
            'password' => 'required',
            'newpassword' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->password, Auth::user()->password)) {
            return redirect()->back()->with('error', 'Current password is incorrect.');
        }

        $user = Auth::user();
        $user->password = Hash::make($request->newpassword);
        $user->save();

        return redirect()->back()->with('success', 'Password changed successfully!');
    }
    public function userDetailsUpdate(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required','phone:EG','unique:users,phone,'.Auth::id()],
        ]);
        $user = Auth::user();
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->save();

        return redirect()->back()->with('success', 'Profile Details changed successfully!');
    }
}
