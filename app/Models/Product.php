<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'slug',
        'description',
        'short_description',
        'price',
        'compare_price',
        'category_id',
        'sub_category_id',
        'brand_id',
        'is_featured',
        'sku',
        'weight',
        'max_order',
        'qty',
        'status',
        'related_product',
        'warranty',
        'return',
        'cachDelivery'
    ];



    public function images(){
        return $this->hasMany(Product_Image::class,'product_id','id');
    }

    public function category(){
        return $this->belongsTo(Category::class,'category_id','id');
    }
    public function subCategory(){
        return $this->belongsTo(SubCategory::class,'sub_category_id','id');
    }
    public function ratings(){
        return $this->hasMany(ProductRating::class,'product_id','id')->where('status','=','1' );
    }

    public function discountPercentage()
    {
        if ($this->compare_price) {
            $discount = ($this->compare_price - $this->price) / $this->compare_price * 100;
            return round($discount, 2);
        }
        return 0;
    }
    // get the average rating as a number
    public function getAverageRatingNumberAttribute()
    {
        return $this->ratings()->avg('rating') ?: 0;
    }
    // get the average rating as a percentage
    public function getAverageRatingPercentageAttribute()
    {
        $averageRating = $this->average_rating_number;
        return $averageRating ? ($averageRating * 100) / 5 : 0;
    }
    //  get the total number of ratings
    public function getRatingCountAttribute()
    {
        return $this->ratings()->count();
    }
    //  get the percentage of each rating (1 to 5)
    public function getRatingPercentage($ratingValue)
    {
        $totalRatings = $this->rating_count;
        if ($totalRatings == 0) {
            return 0;
        }

        $ratingCount = $this->ratings()->where('rating', $ratingValue)->count();
        return ($ratingCount / $totalRatings) * 100;
    }

    public function getOneStarPercentageAttribute()
    {
        return $this->getRatingPercentage(1);
    }

    public function getTwoStarPercentageAttribute()
    {
        return $this->getRatingPercentage(2);
    }

    public function getThreeStarPercentageAttribute()
    {
        return $this->getRatingPercentage(3);
    }

    public function getFourStarPercentageAttribute()
    {
        return $this->getRatingPercentage(4);
    }

    public function getFiveStarPercentageAttribute()
    {
        return $this->getRatingPercentage(5);
    }
}
