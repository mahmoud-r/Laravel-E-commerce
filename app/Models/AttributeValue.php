<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    use HasFactory;

    protected $fillable = ['attribute_id', 'value','slug'];



    public function products(){
        return $this->belongsToMany(Product::class,'product__attributes');
    }
    public function attribute()
    {
        return $this->belongsTo(Attribute::class,'attribute_id');
    }

    public function productAttributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }
}
