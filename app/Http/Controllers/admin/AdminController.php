<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //todo: admin login form
    public function login_form()
    {
        return view('admin.auth.login');
    }

    //todo: admin login functionality
    public function login_functionality(Request $request){
        $request->validate([
            'email'=>'required',
            'password'=>'required',
        ]);

        $remember = $request->has('remember') ? true : false;

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password],$remember)) {


            return redirect()->route('dashboard')->with('success','You are logged in');
        }else{
            return back()->with('error','Invalid Email or Password');
        }
    }




    //todo: admin logout functionality
    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('login.form');
    }
}
