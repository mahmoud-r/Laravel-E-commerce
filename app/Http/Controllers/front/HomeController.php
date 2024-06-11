<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index(){
        $isHomePage = true;
        return view('front.home',compact('isHomePage'));
    }
}
