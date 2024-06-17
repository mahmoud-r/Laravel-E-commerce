<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shipment extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable= [
        'order_id',
        'user_id',
        'weight',
        'note',
        'status',
        'price',
    ];
    public function getShipmentNumberAttribute()
    {
        return '#SHIP-' . (100000000+$this->attributes['id']);
    }
    public static function getIdFromShipmentNumber($shipmentNumber)
    {
        $cleanNumber = str_replace('#SHP-', '', $shipmentNumber);

        return (int)$cleanNumber - 100000000;
    }

    public function order(){
        return $this->belongsTo(Order::class,'order_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function history(){
        return $this->hasMany(ShipmentHistory::class,'shipment_id');
    }
    public function info(){
        return $this->hasOne(ShipmentInfo::class,'shipment_id');
    }
}
