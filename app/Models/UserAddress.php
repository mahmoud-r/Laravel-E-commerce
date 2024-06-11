<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address_name',
        'first_name',
        'last_name',
        'city_id',
        'street',
        'is_primary',
        'phone',
        'second_phone',
        'building',
        'district',
        'governorate_id',
        'nearest_landmark',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function city(){
        return $this->belongsTo(City::class,'city_id','id');
    }
    public function governorate(){
        return $this->belongsTo(Governorate::class,'governorate_id','id');
    }
}
