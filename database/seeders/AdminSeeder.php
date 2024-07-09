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

        $admin = Admin::updateOrCreate([
            'name' => 'Super Admin',
            'email' => 'info@mahmoud-ramadan.com',
            'phone'=>'01146562057',
            'password' => Hash::make('12345678'),
        ]);

        $role = Role::firstOrCreate(['guard_name' => 'admin','name' => 'Super Admin']);

        $permissions = Permission::pluck('id', 'id',)->all();

        $role->syncPermissions($permissions);

        $admin->assignRole([$role->id]);
    }
}
