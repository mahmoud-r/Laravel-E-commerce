<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShipmentInfo extends Model
{

    use HasFactory;
    use SoftDeletes;
    protected $fillable=[
        'shipment_id',
        'shipping_company_name',
        'tracking_id',
        'note',
        'tracking_link',
        'estimate_date_shipped',
    ];

    public function shipment(){
        return $this->belongsTo(Shipment::class,'shipment_id');
    }
}
