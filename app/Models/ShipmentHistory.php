<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShipmentHistory extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable= [
        'action',
        'description',
        'admin_id',
        'shipment_id',
        'order_id',
    ];

    public function order(){
        return $this->belongsTo(Order::class,'order_id');
    }
    public function Shipment(){
        return $this->belongsTo(Shipment::class,'shipment_id');
    }
}
