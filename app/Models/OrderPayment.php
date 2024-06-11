<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderPayment extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'order_payments';
    protected $fillable = [
        'order_id',
        'payment_method',
        'status',
        'amount',
        'paid_at',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
