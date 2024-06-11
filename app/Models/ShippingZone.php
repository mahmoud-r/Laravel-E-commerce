<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingZone extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'additional_weight_price',
        'weight_to',
        'price',
        'delivery_time',
    ];



    public function governorates()
    {
        return $this->belongsToMany(Governorate::class, 'governorate_shipping_zones');
    }
}
