<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    private $permissions = [
        'category-list',
        'category-create',
        'category-edit',
        'category-delete',
        'brand-list',
        'brand-create',
        'brand-edit',
        'brand-delete',
        'attribute-list',
        'attribute-create',
        'attribute-edit',
        'attribute-delete',
        'product-list',
        'product-create',
        'product-edit',
        'product-delete',
        'collection-list',
        'collection-create',
        'collection-edit',
        'collection-delete',
        'reviews-list',
        'reviews-publish',
        'reviews-delete',
        'locations-list',
        'locations-create',
        'locations-edit',
        'locations-delete',
        'shipping-list',
        'shipping-create',
        'shipping-edit',
        'shipping-delete',
        'shipment-list',
        'shipment-update',
        'discount-list',
        'discount-create',
        'discount-edit',
        'discount-delete',
        'admin-list',
        'admin-create',
        'admin-edit',
        'admin-delete',
        'role-list',
        'role-create',
        'role-edit',
        'role-delete',
        'contact-list',
        'contact-delete',
        'newsletter-list',
        'newsletter-create',
        'newsletter-delete',
        'menu-list',
        'menu-create',
        'menu-edit',
        'menu-delete',
        'pages-home-page',
        'pages-home-slider',
        'pages-home-banners',
        'pages-contact-page',
        'pages-about-page',
        'pages-term-condition-page',
        'settings-general',
        'settings-payment-methods',
        'settings-email',
        'settings-social',
        'settings-social-login',
        'settings-recaptcha',
        'order-list',
        'order-delete',
        'order-confirm',
        'order-cancel',
        'order-payment-confirm',
        'order-update-shipping-information',
        'order-update-shipping-status',
        'order-update-note',
        'customer-list',
        'customer-create',
        'customer-edit',
        'customer-delete',
        'customer-address-create',
        'customer-address-edit',
        'customer-address-delete',

    ];
    public function run(): void
    {
        foreach ($this->permissions as $permission) {
            Permission::updateOrCreate(['guard_name' => 'admin','name' => $permission]);


        }

//        $role = Role::where('name', 'Super Admin')->where('guard_name', 'admin')->first();
//
//        if ($role) {
//            $permissions = Permission::where('guard_name', 'admin')->pluck('id', 'id')->all();
//            $role->syncPermissions($permissions);
//        }
    }


}
