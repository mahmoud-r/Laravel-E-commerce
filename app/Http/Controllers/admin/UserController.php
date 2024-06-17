<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdressRequest;
use App\Http\Requests\StoreShippingRequest;
use App\Http\Requests\UpdateAdressRequest;
use App\Models\City;
use App\Models\Governorate;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function index(Request $request)
    {
        return view('admin.users.index');
    }
    public function getAll() {
        $users = User::latest()->get();

        return response()->json($users);
    }


    public function create()
    {
        return view('admin.users.create');

    }


    public function store(Request $request)
    {
        $validator= validator::make($request->all(),[
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'phone:EG', 'unique:users'],
            'status' => ['required','integer','in:0,1'],
            'note' => ['nullable', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);
        if ($validator->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'status' => $request->status,
            'note' => $request->note,
        ]);
        $request->session()->flash('success','User Created successfully');

        return response()->json([
            'status' => true,
            'msg' => 'User Created Successfully'
        ]);
    }


    public function edit( $id)
    {
        $user=User::findOrFail($id);
        $governorates = Governorate::get();
        return view('admin.users.edit',compact('user','governorates'));
    }


    public function update(Request $request, $id)
    {
       $validator= validator::make($request->all(),[
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
            'phone' => ['required', 'phone:EG', 'unique:users,phone,' . $id],
            'status' => ['required','integer','in:0,1'],
            'note' => ['nullable', 'string'],
            'password' => $request->is_change_password ? ['required', 'string', 'min:8', 'confirmed'] : []
        ]);
       if ($validator->fails()){
           return response()->json([
               'status' => false,
               'errors' => $validator->errors()
           ]);
       }
        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => $request->status,
            'note' => $request->note,
        ]);
        if ($request->is_change_password) {
            $user->password = Hash::make($request->password);
            $user->save();
        }
        $request->session()->flash('success','User Updated successfully');

        return response()->json([
            'status' => true,
            'msg' => 'User Updated Successfully'
        ]);
    }


    public function destroy( $id)
    {
        $user = User::findOrFail($id);

        if ($user->delete()) {
            return response()->json([
                'status' => true,
                'msg' => 'User Deleted Successfully',
                'deleted_id' => $id
            ]);
        } else {
            return response()->json([
                'status' => false,
                'msg' => 'Something went wrong',
            ], 500);
        }
    }

    public function createAddress(StoreAdressRequest $request,$user){

        $user = User::findOrFail($user);
        $address = $user->addresses()->create($request->validated());
        $request->session()->flash('success','Address Created successfully');

        return response()->json([
            'status' =>true,
            'msg' =>'Address Created successfully.',
        ]);
    }
    public function editAddress($address){
        $address = UserAddress::findOrFail($address);
        $governorates = Governorate::get();
        $cities = City::where('governorate_id',$address->governorate_id)->get();
        return view('admin.users.edit_address_model',compact('address','governorates','cities'))->render();
    }
    public function updateAddress(UpdateAdressRequest $request,$address){
        $address = UserAddress::findOrFail($address);
        $address->update($request->validated());

        $request->session()->flash('success','Address Updated successfully');

        return response()->json([
            'status' =>true,
            'msg' =>'Address Updated successfully.',
        ]);
    }
    public function deleteAddress($id){
        $address = UserAddress::findOrFail($id);
        if ($address->delete()) {
            return response()->json([
                'status' => true,
                'msg' => 'Address Deleted Successfully',
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
