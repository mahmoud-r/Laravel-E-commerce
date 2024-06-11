<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\Product_Image;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

function getCategories(){

   return Category::where('status', 1)
       ->whereHas('products')
       ->orWhereHas('subCategories.products')
       ->with('subCategories')
       ->select('id', 'name', 'slug')
       ->latest()
       ->get();;

}

function makeNonNegative($value) {
    return max($value, 0);
}

function getProductImage($productId){
    return Product_Image::where('product_id',$productId)->first();
}
function getProductslug($productId){
    return Product::where('id',$productId)->select('slug')->first();
}
function getWishlistCount(){
     return Auth::check() ?   Wishlist::where('user_id',Auth::user()->id)->count() : 0 ;
}
