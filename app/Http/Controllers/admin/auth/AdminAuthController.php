<?php

namespace App\Http\Controllers\admin\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function login_form()
    {
        return view('admin.auth.nlogin');
    }

    public function login_functionality(Request $request){
        $request->validate([
            'email'=>'required',
            'password'=>'required',
        ]);

        $remember = $request->has('remember');

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password],$remember)) {

            return redirect()->route('dashboard')->with('success','You are logged in');
        }else{
            return back()->with('error','Invalid Email or Password');
        }
    }





    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('login.form');
    }
}
