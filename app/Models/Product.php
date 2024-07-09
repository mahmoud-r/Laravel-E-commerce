<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

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
        'sku',
        'weight',
        'max_order',
        'qty',
        'status',
        'related_product',
        'warranty',
        'return',
        'seo_title',
        'seo_description',
        'seo_index',
        'flash_sale_price',
        'flash_sale_expiry_date',
        'flash_sale_qty',
        'flash_sale_qty_solid',

    ];

    public function scopeInFlashSale($query)
    {
        return $query->whereNotNull('flash_sale_price')
            ->where('flash_sale_qty', '>', 0)
            ->whereDate('flash_sale_expiry_date', '>=', Carbon::now()->format('Y-m-d H:i:s'));
    }

    public function scopeIsActive($query)
    {
        return $query
            ->where('qty', '>', 0)
            ->orWhere('flash_sale_qty','>',0)
            ->where('status',true);
    }

    public function images(){
        return $this->hasMany(Product_Image::class,'product_id','id');
    }

    public function category(){
        return $this->belongsTo(Category::class,'category_id','id');
    }
    public function subCategory(){
        return $this->belongsTo(SubCategory::class,'sub_category_id','id');
    }
    public function brand(){
        return $this->belongsTo(Brand::class,'brand_id','id');
    }
    public function ratings(){
        return $this->hasMany(ProductRating::class,'product_id','id')->where('status','=','1' );
    }
    public function productAttributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function attributes()
    {
        return $this->hasManyThrough(Attribute::class, ProductAttribute::class,'product_id','id','id','attribute_id');
    }

    public function attributeValues()
    {
        return $this->hasManyThrough(AttributeValue::class, ProductAttribute::class,'product_id','id','id','attribute_value_id');
    }

    public function Collections(){
        return $this->belongsToMany(ProductCollection::class,'product_collection_products');
    }


    public function getPriceAttribute($value)
    {
        if ($this->flash_sale_price && $this->flash_sale_expiry_date && Carbon::now()->lessThan($this->flash_sale_expiry_date) && $this->flash_sale_qty > 0) {
            return $this->flash_sale_price;
        }

        return $value;
    }
    public function getQtyAttribute($value)
    {
        if ($this->flash_sale_qty && $this->flash_sale_expiry_date && Carbon::now()->lessThan($this->flash_sale_expiry_date)) {
            return $this->flash_sale_qty;
        }
        return $value;
    }
    public function getComparePriceAttribute($value)
    {
        if ($this->flash_sale_price !== null) {
            return !is_null($this->attributes['compare_price']) ? $this->attributes['compare_price'] : $this->attributes['price'];
        }
        return $value;
    }

    public function getSeoTitleAttribute()
    {
        return !empty($this->attributes['seo_title']) ? $this->attributes['seo_title'] : $this->attributes['title'];
    }
    public function getSeoDescriptionAttribute()
    {
        $short_description = strip_tags($this->attributes['short_description']);
        return !empty($this->attributes['seo_description']) ? $this->attributes['seo_description'] : substr($short_description, 0, 170);
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
