<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order_item extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'order_items';
    protected $fillable = [
        'order_id',
        'product_id',
        'name',
        'qty',
        'price',
        'total',
    ];

    public function order(){
        return $this->belongsTo(Order::class,'order_id','id');
    }

    public function product(){
        return $this->belongsTo(Product::class,'product_id','id');
    }

}
