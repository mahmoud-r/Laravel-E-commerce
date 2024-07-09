<?php

namespace App\Http\Controllers\admin\admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','show'] ]);
        $this->middleware('permission:role-create', ['only' => ['create','store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {

        $roles = Role::whereNotIn('name', ['Super Admin'])->orderBy('id','DESC')->get();
        return view('admin.admins.roles.index',compact('roles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }


    public function create()
    {
        $permission = Permission::get();
        $groupedPermissions = $permission->groupBy(function($item, $key) {
            return explode('-', $item->name)[0];
        });
        return view('admin.admins.roles.create',compact('permission','groupedPermissions'));
    }


    public function store(Request $request)
    {
       $validator =  Validator::make($request->all(), [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

        if ($validator->fails()){
            return response()->json([
                'status' =>false,
                'errors' =>$validator->errors()
            ]);
        }

        $role = Role::create(['name' => $request->input('name'),'guard_name' => 'admin']);
        $role->syncPermissions($request->input('permission'));

        $request->session()->flash('success','Role created successfully');

        return response()->json([
            'status' =>true,
            'msg' =>'category added successfully'
        ]);
    }

    public function show($id)
    {
        $role = Role::find($id);
        $permission = Permission::get();

        $groupedPermissions = $permission->groupBy(function($item, $key) {
            return explode('-', $item->name)[0];
        });
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();

        return view('admin.admins.roles.show',compact('role','rolePermissions','permission','groupedPermissions'));
    }


    public function edit($id)
    {
        $role = Role::whereNotIn('name', ['Super Admin'])->find($id);
        if (!$role) {
            return redirect()->back()->with('error','Role Not Found');
        }
        $permission = Permission::get();
        $groupedPermissions = $permission->groupBy(function($item, $key) {
            return explode('-', $item->name)[0];
        });
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();

        return view('admin.admins.roles.edit',compact('role','permission','rolePermissions','groupedPermissions'));
    }


    public function update(Request $request, $id)
    {
        $validator =  Validator::make($request->all(), [
            'name' => 'required|unique:roles,name,'.$id,
            'permission' => 'required',
        ]);

        if ($validator->fails()){
            return response()->json([
                'status' =>false,
                'errors' =>$validator->errors()
            ]);
        }

        $role = Role::whereNotIn('name', ['Super Admin'])->find($id);
        if (!$role) {
            return redirect()->back()->with('error','Role Not Found');
        }
        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permission'));

        return response()->json([
            'status' =>true,
            'msg' =>'Role updated successfully'
        ]);
    }

    public function destroy($id)
    {
        DB::table("roles")->where('id',$id)->delete();

        return response()->json([
            'status' => true,
            'msg' => 'role Deleted Successfully',
            'deleted_id' => $id
        ]);
    }
}
