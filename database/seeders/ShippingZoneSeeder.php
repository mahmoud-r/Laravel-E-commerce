<?php

namespace Database\Seeders;

use App\Models\ShippingZone;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShippingZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ShippingZone::create([
            'name' => 'Default',
            'delivery_time' => '5-7 days',
            'weight_to' => 1000,
            'price' => 50.00,
            'additional_weight_price' => 10.00,
        ]);
    }
}
