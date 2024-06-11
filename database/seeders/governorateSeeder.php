<?php

namespace Database\Seeders;

use App\Models\Governorate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class governorateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('governorates')->delete();
        $json = File::get(database_path('data/governorates.json'));
        $data = json_decode($json);
        foreach ($data as $obj){
            Governorate::create([
                'governorate_name_en' => $obj->governorate_name_en,
                'governorate_name_ar' => $obj->governorate_name_ar,
            ]);
        }
    }
}
