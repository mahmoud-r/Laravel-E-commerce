<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Governorate extends Model
{
    use HasFactory;
    protected $table = 'governorates';
    protected $fillable = [
        'governorate_name_en',
        'governorate_name_ar',
    ];


    public function Cities(){
        return $this->hasMany(City::class,'governorate_id','id');
    }

    public function shippingZones()
    {
        return $this->belongsToMany(ShippingZone::class, 'governorate_shipping_zones');
    }
}
