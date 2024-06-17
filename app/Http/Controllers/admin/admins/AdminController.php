<?php

namespace App\Http\Controllers\admin\admins;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{

    public function index()
    {

        return view('admin.admins.index');
    }

    public function getAll() {
        $admins = Admin::whereNotIn('name', ['Super Admin'])->latest()->get()->map(function ($admin){
            $roles = [];
            foreach ($admin->getRoleNames() as $role){
                $roles[] =$role;
            }
            return [
                'id' => $admin->id,
                'name' => $admin->name,
                'email' => $admin->email,
                'status' => $admin->status,
                'notification' => $admin->notification,
                'index' => $admin->index,
                'roles' => $roles,
                'phone'=>$admin->phone,
                'created_at'=>$admin->created_at,

            ];
        });
        return response()->json($admins);
    }

    public function create()
    {
        $roles = Role::whereNotIn('name', ['Super Admin'])->pluck('name','name')->all();
        return view('admin.admins.create',compact('roles'));

    }


    public function store(Request $request)
    {
        $validator= validator::make($request->all(),[
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
            'phone' => ['required', 'phone:EG', 'unique:admins'],
            'status' => ['required','integer','in:0,1'],
            'notification' => ['required','integer','in:0,1'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);
        if ($validator->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
       $admin= Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'status' => $request->status,
            'notification' => $request->notification,
        ]);
        $admin->assignRole($request->input('roles'),'admin');

        $request->session()->flash('success','admin Created successfully');

        return response()->json([
            'status' => true,
            'msg' => 'admin Created Successfully'
        ]);
    }


    public function edit( $id)
    {
        $admin=Admin::findOrFail($id);
        $roles = Role::whereNotIn('name', ['Super Admin'])->pluck('name','name')->all();
        $adminRole = $admin->roles->pluck('name','name')->all();

        return view('admin.admins.edit',compact('admin','roles','adminRole'));
    }


    public function update(Request $request, $id)
    {
        $validator= validator::make($request->all(),[
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins,email,' . $id],
            'phone' => ['required', 'phone:EG', 'unique:admins,phone,' . $id],
            'status' => ['required','integer','in:0,1'],
            'notification' => ['required','integer','in:0,1'],
            'password' => $request->is_change_password ? ['required', 'string', 'min:8', 'confirmed'] : []
        ]);
        if ($validator->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
        $admin = Admin::findOrFail($id);
        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => $request->status,
            'notification' => $request->notification,
        ]);
        if ($request->is_change_password) {
            $admin->password = Hash::make($request->password);
            $admin->save();
        }
        DB::table('model_has_roles')->where('model_id',$id)->delete();

        $admin->assignRole($request->input('roles'));

        $request->session()->flash('success','Admin Updated successfully');

        return response()->json([
            'status' => true,
            'msg' => 'Admin Updated Successfully'
        ]);
    }


    public function destroy( $id)
    {
        $admin = Admin::findOrFail($id);

        if ($admin->delete()) {
            return response()->json([
                'status' => true,
                'msg' => 'Admin Deleted Successfully',
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
