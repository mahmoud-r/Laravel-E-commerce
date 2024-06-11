<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Vinkla\Hashids\Facades\Hashids;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'orders';
    protected $fillable = [
        'user_id',
        'subtotal',
        'shipping',
        'coupon_code',
        'coupon_code_id',
        'discount',
        'grand_total',
        'notes',
        'payment_method',

    ];

    public function getOrderNumberAttribute()
    {
        return '#ORD-' . (100000000 + $this->attributes['id']);
    }

    public function getRouteKey()
    {
        return Hashids::encode($this->getKey());
    }

    static function getId($id)
    {
        return Hashids::decode($id)[0] ?? null;
    }

    public function items()
    {
        return $this->hasMany(Order_item::class, 'order_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function status()
    {
        return $this->hasOne(OrderStatue::class, 'order_id');
    }

    public function Payment()
    {
        return $this->hasOne(OrderPayment::class, 'order_id');
    }

    public function Shipment()
    {
        return $this->hasOne(Shipment::class, 'order_id');
    }

    public function history()
    {
        return $this->hasMany(OrderHistory::class, 'order_id');
    }

    public function address()
    {
        return $this->hasOne(OrderAddress::class, 'order_id');
    }

    public static function checkOrderCompletion($orderId)
    {
        $order = self::find($orderId);

        if ($order->payment->status == 'completed' && $order->shipment->status == 'Delivered') {
            $order->status->update(['status' => 'completed']);
        } elseif ($order->payment->status == 'failed' && $order->shipment->status == 'Canceled') {
            $order->status->update(['status' => 'cancelled']);
        } elseif ( $order->shipment->status == 'Delivering') {
            $order->status->update(['status' => 'shipping']);
        }
    }

}