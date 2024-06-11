<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderHistory extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'action',
        'description',
        'admin_id',
        'admin_name',
        'order_id',
    ];


    public function order(){
       return $this->belongsTo(Order::class,'order_id');
    }
}
