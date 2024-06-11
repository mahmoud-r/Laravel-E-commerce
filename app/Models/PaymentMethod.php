<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;
    protected $fillable = [
        'payment_method', 'key', 'value'
    ];

    public static function getSettings($method)
    {
        return self::where('payment_method', $method)->pluck('value', 'key')->toArray();
    }
}
