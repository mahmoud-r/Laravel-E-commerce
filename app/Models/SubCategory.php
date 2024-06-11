<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SubCategory extends Model
{
    use HasFactory;
    protected $fillable = ['name','slug','status','category_id','showHome'];



    public function category(){

        return $this->belongsTo(Category::class,'category_id','id');

    }
    public function products(){
        return $this->hasMany(Product::class,'sub_category_id','id');
    }


}
