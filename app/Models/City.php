<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $table = 'cities';
    protected $fillable = [
        'governorate_id',
        'city_name_ar',
        'city_name_en'
    ];

    public function governorate(){
      return  $this->belongsTo(Governorate::class,'governorate_id','id');
    }

}
