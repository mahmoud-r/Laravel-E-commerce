<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderAddress extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $fillable = [
        'order_id',
        'first_name',
        'last_name',
        'city_id',
        'street',
        'phone',
        'second_phone',
        'building',
        'district',
        'governorate_id',
        'nearest_landmark',
    ];


    public function order(){
        return $this->belongsTo(Order::class,'order_id');
    }
    public function city(){
        return $this->belongsTo(City::class,'city_id','id');
    }
    public function governorate(){
        return $this->belongsTo(governorate::class,'governorate_id','id');
    }
}
