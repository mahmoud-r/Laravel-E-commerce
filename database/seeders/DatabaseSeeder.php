<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
//        \App\Models\Admin::create([
//            'name' => 'admin',
//            'email' => 'mahmodramadan4413@gmail.com',
//            'password' => Hash::make('12345678'),
//        ]);
         \App\Models\Category::factory(100)->create();
//         \App\Models\SubCategory::factory(25)->create();
//         \App\Models\Brand::factory(5)->create();
//         \App\Models\Product::factory(20)->create();
//        $this->call(governorateSeeder::class);
//        $this->call(citySeeder::class);
//        $this->call(ShippingZoneSeeder::class);
//        $this->call(PaymentMethodsSeeder::class);

    }

}
