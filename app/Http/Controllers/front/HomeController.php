<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactRequest;
use App\Mail\ContactMail;
use App\Mail\ContactMailAdmin;
use App\Models\Admin;
use App\Models\Contact;
use App\Models\Newsletter;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function index(){

        $isHomePage = true;
        return view('front.home',compact('isHomePage'));
    }


    public function storeNewsletter(Request $request){
        $validator = Validator::make($request->all(),[
            'email'=>'email|required|unique:newsletters'
        ]);

        if ($validator->fails()){
            return response()->json([
                'status'=>false,
                'errors'=>$validator->errors()
            ]);
        }
        Newsletter::create($request->only('email'));

        return response()->json([
            'status'=>true,
            'msg'=>'email Created successfully'
        ]);

    }

    //Pages

    //contact
    public function contactPage(){
        $contactPage = Page::getContent('contact');
        return view('front.pages.contact',compact('contactPage'));
    }
    public function storeContactForm(StoreContactRequest $request){

        $Contact =Contact::create($request->input());


        try {
            if (get_setting('email_user_new_contact')){
                Mail::to($Contact->email)->send(new ContactMail($Contact));
            }
            if (get_setting('email_user_new_contact_admin')){
                $admins = Admin::where('notification', '1')->pluck('email')->toArray();

                Mail::to($admins)->send(new ContactMailAdmin($Contact));
            }
        } catch (\Exception $e) {
            Log::error('Failed to send Contact Mail : ' . $e->getMessage());
        }

        return response()->json([
            'status'=>true,
            'msg'=>'Thank you for your message!'
        ]);
    }

    //about
    public function aboutPage(){
        $aboutPage = Page::getContent('about');
        return view('front.pages.about',compact('aboutPage'));
    }

    //term & Condition
    public function termConditionPage(){
        $Page = Page::getContent('term-condition');
        return view('front.pages.term-condition',compact('Page'));
    }

}
