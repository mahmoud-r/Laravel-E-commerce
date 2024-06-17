<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Create admin User and assign the role to him.
        $admin = Admin::create([
            'name' => 'Super Admin',
            'email' => 'mahmodramadan4413@gmail.com',
            'phone'=>'01146562057',
            'password' => Hash::make('12345678'),
        ]);

        $role = Role::create(['guard_name' => 'admin','name' => 'Super Admin']);

        $permissions = Permission::pluck('id', 'id',)->all();

        $role->syncPermissions($permissions);

        $admin->assignRole([$role->id]);
    }
}
