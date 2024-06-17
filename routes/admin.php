<?php

use App\Http\Controllers\admin\admins\AdminController;
use App\Http\Controllers\admin\admins\RoleController;
use App\Http\Controllers\admin\auth\AdminAuthController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\orders\OrderController;
use App\Http\Controllers\admin\orders\ShipmentController;
use App\Http\Controllers\admin\settings\CitesController;
use App\Http\Controllers\admin\settings\DiscountCouponController;
use App\Http\Controllers\admin\settings\GovernorateController;
use App\Http\Controllers\admin\settings\PaymentMethodController;
use App\Http\Controllers\admin\settings\SettingsController;
use App\Http\Controllers\admin\settings\ShippingController;
use App\Http\Controllers\admin\shop\BrandController;
use App\Http\Controllers\admin\shop\CategoryController;
use App\Http\Controllers\admin\shop\ProductController;
use App\Http\Controllers\admin\shop\ProductRatingController;
use App\Http\Controllers\admin\shop\SubCategoryController;
use App\Http\Controllers\admin\TempImagesController;
use App\Http\Controllers\admin\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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


Route::group(['prefix'=>'dashboard'],function (){


    Route::get('login',[AdminAuthController::class,'login_form'])->name('login.form');
    Route::post('login-functionality',[AdminAuthController::class,'login_functionality'])->name('login.functionality');


    Route::group(['middleware'=>'auth.admin'],function(){

        Route::get('/',[DashboardController::class,'dashboard'])->name('dashboard');
        Route::get('logout',[AdminAuthController::class,'logout'])->name('dashboard.logout');

        //Users
        Route::post('user/create_address/{user}',[UserController::class,'createAddress'])->name('createAddress');
        Route::get('users/getall',[UserController::class,'getAll'])->name('users.getAll');
        Route::get('user/address/edit/{address}',[UserController::class,'editAddress'])->name('editUserAddress');
        Route::put('user/address/update/{address}',[UserController::class,'updateAddress'])->name('updateUserAddress');
        Route::delete('user/address/delete/{address}',[UserController::class,'deleteAddress'])->name('deleteUserAddress');
        Route::resource('users',UserController::class);


        //Admins
        Route::get('admins/getall',[AdminController::class,'getAll'])->name('admins.getAll');
        Route::resource('admins', AdminController::class);

        //Roles
        Route::resource('roles', RoleController::class);



//        categores
        Route::post('/upload-temp-image',[TempImagesController::class,'create'])->name('temp-images.create');
        Route::get('categories/getall',[CategoryController::class,'getAll'])->name('categories.getAll');
        Route::resource('categories',CategoryController::class);


        // sub Category
        Route::name('sub_category.')->prefix('sub_categories')->group(function (){
            Route::get('/{category}',[SubCategoryController::class,'index'])->name('index');
            Route::get('/getall/{category}',[SubCategoryController::class,'getAll'])->name('getAll');
            Route::post('/store',[SubCategoryController::class,'store'])->name('store');
            Route::get('/create/{category}',[SubCategoryController::class,'create'])->name('create');
            Route::get('/edit/{sub_category}',[SubCategoryController::class,'edit'])->name('edit');
            Route::put('/update/{sub_category}',[SubCategoryController::class,'update'])->name('update');
            Route::delete('/destroy/{sub_category}',[SubCategoryController::class,'destroy'])->name('destroy');
        });


        //brands
        Route::get('brands/getall',[BrandController::class,'getAll'])->name('brands.getAll');
        Route::resource('brands',BrandController::class);


        //shipping
        Route::resource('shipping',ShippingController::class);
        //governorate
        Route::resource('governorate',GovernorateController::class);
        //city
        Route::name('cities.')->prefix('cities')->group(function (){
            Route::get('/{governorate}',[CitesController::class,'index'])->name('index');
            Route::get('/create/{governorate}',[CitesController::class,'create'])->name('create');
            Route::post('/{governorate}',[CitesController::class,'store'])->name('store');
            Route::get('edit/{city}',[CitesController::class,'edit'])->name('edit');
            Route::put('update/{city}',[CitesController::class,'update'])->name('update');
            Route::delete('destroy/{city}',[CitesController::class,'destroy'])->name('destroy');

        });

        //products
        Route::get('get_sub_categories',[ProductController::class,'get_sub_categories'])->name('getsubcategory');
        Route::get('/get-products',[ProductController::class,'getProducts'])->name('products.getProducts');
        Route::post('/products/updateImages',[ProductController::class,'updateImages'])->name('product_update_images');
        Route::get('products/getall',[ProductController::class,'getAll'])->name('products.getAll');
        Route::delete('/products/deleteImages',[ProductController::class,'deleteImages'])->name('product_delete_images');
        Route::resource('products',ProductController::class);

        //DiscountCoupon
        Route::resource('discount',DiscountCouponController::class);


        //orders
        Route::get('orders',[OrderController::class,'index'])->name('orders.index');
        Route::get('orders/getall',[OrderController::class,'getAll'])->name('orders.getAll');
        Route::get('order/{order}',[OrderController::class,'orderView'])->name('order.view');
        Route::delete('order/destroy/{order}',[OrderController::class,'destroy'])->name('order.destroy');
        Route::post('order/shipment/update_status/{shipment}',[OrderController::class,'shipmentUpdateStatus'])->name('shipment_update_status');
        Route::post('/payment/update_status/{payment}',[OrderController::class,'paymentUpdateStatus'])->name('payment_update_status');
        Route::post('/order_confirm',[OrderController::class,'OrderConfirm'])->name('OrderConfirm');
        Route::post('/order_cancel',[OrderController::class,'orderCancel'])->name('orderCancel');
        Route::post('/admin_order_note',[OrderController::class,'updateOrderNote'])->name('updateOrderNote');
        Route::Put('/update_order_address/{address}',[OrderController::class,'UpdateAddress'])->name('UpdateAddress');

        //shipment
        Route::get('shipments',[ShipmentController::class,'index'])->name('shipments.index');
        Route::get('shipments/getall',[ShipmentController::class,'getAll'])->name('shipments.getAll');
        Route::get('shipment/{shipment}',[ShipmentController::class,'shipmentView'])->name('shipment.view');
        Route::post('/shipment/update_status/{shipment}',[ShipmentController::class,'shipmentUpdateStatus'])->name('shipment_Update_Status');
        Route::post('/shipment/update_info/{shipment}',[ShipmentController::class,'shipmentUpdateInfo'])->name('shipmentUpdateInfo');


        //Payment
        Route::get('/payment-methods',[PaymentMethodController::class,'index'])->name('payment_methods.index');
        Route::post('/payment-methods/update', [PaymentMethodController::class, 'update'])->name('payment-methods.update');
        Route::post('/payment-methods/update_status', [PaymentMethodController::class, 'updateStatus'])->name('payment-methods.updateStatus');

        //reviews
        Route::name('reviews.')->prefix('reviews')->group(function (){
            Route::get('/',[ProductRatingController::class,'index'])->name('index');
            Route::delete('/destroy/{review}',[ProductRatingController::class,'destroy'])->name('destroy');
            Route::post('/reviews/publish',[ProductRatingController::class,'publishToggle'])->name('publishToggle');
            Route::get('getall',[ProductRatingController::class,'getAll'])->name('getAll');


        });


        //Settings
        Route::name('settings.')->prefix('settings')->group(function (){
            Route::get('/',[SettingsController::class,'index'])->name('index');
            Route::put('/store',[SettingsController::class,'store'])->name('store');
            Route::get('/email',[SettingsController::class,'email'])->name('email');
            Route::get('/general',[SettingsController::class,'general'])->name('general');

        });

        //helper
        Route::get('/getslug', function(Request $request){
            $slug = '';

            if (!empty($request->title)){

                $slug =Str::slug($request->title);

                return response()->json([
                    'status' =>true,
                    'slug' =>$slug
                ]);
            }
        })->name('getslug');

    });

});



