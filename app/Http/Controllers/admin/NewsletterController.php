<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:newsletter-list|newsletter-delete|newsletter-create', ['only' => ['index','getAll','show'] ]);
        $this->middleware('permission:newsletter-create', ['only' => ['store']]);
        $this->middleware('permission:newsletter-delete', ['only' => ['destroy']]);

    }
    public function index(){
        return view('admin.newsletter.index');
    }

    public function getAll() {
        $emails = Newsletter::latest()->get();
        return response()->json($emails);
    }


    public function store(Request $request){
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

        session()->flash('success','email Created successfully');
        return response()->json([
            'status'=>true,
            'msg'=>'email Created successfully'
        ]);

    }

    public function destroy( $id)
    {
        $Email= Newsletter::findOrFail($id);

        if ($Email->delete()) {
            return response()->json([
                'status' => true,
                'msg' => 'Email Deleted Successfully',
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
