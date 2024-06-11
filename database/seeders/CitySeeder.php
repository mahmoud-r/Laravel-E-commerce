<?php

namespace Database\Seeders;

use App\Models\city;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cities')->delete();
        $json = File::get(database_path('data/cities.json'));
        $data = json_decode($json);
        foreach ($data as $obj){
            city::create([
                'governorate_id' => $obj->governorate_id,
                'city_name_ar' => $obj->city_name_ar,
                'city_name_en' => $obj->city_name_en,
            ]);
        }
    }

}
