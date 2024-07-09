<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;

class ContactController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:contact-list|contact-delete', ['only' => ['index','getAll','show'] ]);
        $this->middleware('permission:contact-delete', ['only' => ['destroy']]);

    }
    public function index(){
        return view('admin.contact.index');
    }

        public function getAll() {
        $contacts = Contact::latest()->get();

        return response()->json($contacts);
    }

    public function show($id){
        $contact = Contact::findOrFail($id);
        return view('admin.contact.show',compact('contact'));
    }

    public function destroy( $id)
    {
        $Contact= Contact::findOrFail($id);

        if ($Contact->delete()) {
            return response()->json([
                'status' => true,
                'msg' => 'Contact Deleted Successfully',
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
