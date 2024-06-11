<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderStatue extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'order_statuses';
    protected $fillable = ['order_id', 'admin_id', 'status', 'admin_note'];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }


}
