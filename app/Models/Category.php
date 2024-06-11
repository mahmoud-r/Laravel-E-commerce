<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;
    protected $fillable=['name','slug','image','status','showHome'];



    public function subCategories(){
        return $this->hasMany(SubCategory::class,'category_id','id');
    }

    public function products(){
        return $this->hasMany(Product::class,'category_id','id');
    }

}
