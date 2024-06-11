<?php

use App\Http\Controllers\front\CartController;
use App\Http\Controllers\front\CheckoutController;
use App\Http\Controllers\front\CompareController;
use App\Http\Controllers\front\HomeController;
use App\Http\Controllers\front\ShopController;
use App\Http\Controllers\front\UserAddressController;
use App\Http\Controllers\front\UserProfileController;
use App\Http\Controllers\front\WishlistController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//home
Route::get('/',[HomeController::class,'index'])->name('home');


Route::name('front.')->group(function (){
    //shop
    Route::get('shop/{categorySlug?}/{subCategorySlug?}',[ShopController::class,'index'])->name('shop');
    Route::get('product/{slug}',[ShopController::class,'product'])->name('product');
    Route::get('shop-quick-view/{id}',[ShopController::class,'quickView'])->name('quick-view');
    Route::post('save_rating/{product}',[ShopController::class,'saveRating'])->name('saveRating');

    //search
    Route::get('/search',[ShopController::class,'search'])->name('search.products');

    //cart
    Route::get('/cart',[CartController::class,'cart'])->name('cart');
    Route::post('/add-to-cart',[CartController::class,'addToCart'])->name('addToCart');
    Route::post('/update-cart',[CartController::class,'updateCart'])->name('updateCart');
    Route::post('/delete-item',[CartController::class,'deleteItem'])->name('deleteItem');
    Route::get('/getMiniCart', [CartController::class, 'getMiniCart'])->name('getMiniCart');
    Route::get('/check-cart-updates', [CartController::class, 'checkUpdates'])->name('checkCartUpdates');

    //Compare

    Route::name('compare.')->prefix('compare')->group(function () {
        Route::get('/', [CompareController::class, 'index'])->name('index');
        Route::get('/show/{productId}', [CompareController::class, 'show'])->name('show');
        Route::delete('/destroy/{productId}', [CompareController::class, 'destroy'])->name('destroy');
    });

    //wishlist
    Route::post('add_to_wishlist',[WishlistController::class,'addToWishlist'])->name('addToWishlist');
    Route::get('wishlist',[WishlistController::class,'index'])->name('wishlist.index');


    Route::group(['middleware'=>'auth'],function(){

        //user profile
        Route::get('/my-account',[UserProfileController::class,'index'])->name('profile');
        Route::get('/my-account/orders',[UserProfileController::class,'orders'])->name('orders');
        Route::get('/my-account/reviews',[UserProfileController::class,'reviews'])->name('reviews');
        Route::get('/my-account/orders/view/{order}',[UserProfileController::class,'showOrder'])->name('showOrder');
        Route::get('/my-account/address',[UserProfileController::class,'address'])->name('address');
        Route::get('/my-account/change-password',[UserProfileController::class,'changePasswordForm'])->name('change-password');
        Route::post('/my-account/change-password',[UserProfileController::class,'changePassword'])->name('changePassword');
        Route::get('/my-account/account-detail',[UserProfileController::class,'accountDetail'])->name('accountDetail');
        Route::post('/my-account/account-detail',[UserProfileController::class,'userDetailsUpdate'])->name('userDetailsUpdate');

        //wishlist
        Route::get('wishlist',[WishlistController::class,'index'])->name('wishlist.index');
        Route::delete('wishlist/delete',[WishlistController::class,'destroy'])->name('removeFromWishlist');

        Route::get('/getaddress/{id}',[UserAddressController::class,'getaddress'])->name('getaddress');
        Route::get('/getcities',[UserAddressController::class,'getCities'])->name('getCities');
        Route::resource('address',UserAddressController::class);




        //checkout
        Route::get('/checkout',[CheckoutController::class,'index'])->name('checkout');
        Route::post('/process_checkout',[CheckoutController::class,'process_checkout'])->name('process_checkout');
        Route::post('/getOrderSummery',[CheckoutController::class,'getOrderSummery'])->name('getOrderSummery');
        Route::post('/apply_discount',[CheckoutController::class,'applyDiscount'])->name('applyDiscount');
        Route::post('/remove_coupon',[CheckoutController::class,'RemoveCoupon'])->name('RemoveCoupon');
        Route::get('/order_completed/{order}',[CheckoutController::class,'orderCompleted'])->name('orderCompleted');


    });

});



Auth::routes();

