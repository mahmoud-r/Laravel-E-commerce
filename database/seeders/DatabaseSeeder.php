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


        $this->call(SettingsSeeder::class);
        $this->call(PagesSeeder::class);

        $this->call(PermissionSeeder::class);
        $this->call(AdminSeeder::class);

//         \App\Models\Category::factory(5)->create();
//         \App\Models\SubCategory::factory(25)->create();
//         \App\Models\Brand::factory(5)->create();
//         \App\Models\Product::factory(20)->create();
        $this->call(governorateSeeder::class);
        $this->call(citySeeder::class);
        $this->call(ShippingZoneSeeder::class);
        $this->call(PaymentMethodsSeeder::class);

    }

}
