<?php

use App\Models\Category;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\Product_Image;
use App\Models\Settings;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;


if (!function_exists('get_setting')) {
    function get_setting($key, $default = null)
    {
        return Settings::get($key, $default);
    }
}

if (!function_exists('getPageContent')) {
    function getPageContent($key, $default = null)
    {
        return Page::getContent($key, $default);
    }
}
if (!function_exists('getPaymentMethod')) {
    function getPaymentMethod($key)
    {
        return PaymentMethod::getSettings($key);
    }
}
function getCategories(){

   return Category::where('status', 1)
       ->whereHas('products')
       ->orWhereHas('subCategories.products')
       ->with('subCategories')
       ->select('id', 'name', 'slug','image')
       ->orderBy('sort','asc')
       ->get();

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



function getMenu($location){

    $menu = menu::where('location',$location)->first();
    if ($menu) {
        $menuitems = $menu->getMenuItems();
        $title = $menu->title;
    } else {
        $menuitems = [];
        $title = '';
    }
    return ['title'=>$title,'items'=>$menuitems];
}
