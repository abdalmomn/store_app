<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RepairingCenterController;
use App\Http\Controllers\TradeCenterController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\WishlistController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductPhotoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });

    Route::controller(AuthController::class)->group(function (){
        Route::post('client_register' , 'register_as_client')->name('user.client_register');
        Route::post('seller_register' , 'register_as_seller')->name('user.seller_register');
        Route::post('login' , 'login')->name('user.login');
        Route::group(['middleware' => ['auth:sanctum']] , function (){
            Route::get('logout' , 'logout')->name('user.logout');
        });
        Route::get('forget_password' , 'forget_password')->name('user.forget_password');
        Route::get('check_code' , 'check_code')->name('user.check_code');
        Route::post('resend_code' , 'resend_code')->name('user.resend_code');
        Route::get('reset_password' , 'reset_password')->name('user.reset_password');

        Route::get('auth/google' , 'redirect_to_google');
        Route::get('auth/google/callback' , 'google_handle_call_back');
    });

    Route::post('/email/verification-notification' , function (Request $request){
        $request->user()->sendEmailVerificationNotification();
        return response()->json(['message' => 'new verification link sent!']);
    })->middleware(['auth:sanctum' , 'throttle:6,1'])->name('verification.send');


    Route::controller(ProfileController::class)
        ->middleware('auth:sanctum')->group(function (){
            Route::get('/all' , 'show_all_profiles');
            Route::get('/show/{id}' , 'show_user_profile');
            Route::post('/update' , 'update_profile');
            Route::post('password/update' , 'update_password');
            Route::delete('/delete' , 'delete_my_profile');
            Route::delete('/delete/{id}' , 'delete_profile');
    });

    Route::controller(CartController::class)
        ->middleware('auth:sanctum')->group(function (){
        Route::get('/cart', 'show_cart');
        Route::delete('/cart/delete/{product_id}', 'delete_from_cart');
        Route::post('/add_to_cart/{product_id}', 'add_to_cart');
    });


    Route::controller(OrderController::class)
        ->middleware('auth:sanctum')->group(function(){
            Route::post('/checkout' , 'checkout');
            Route::post('/place_order' , 'place_order');
            Route::get('/cancel_placed_order/{order_id}' , 'cancel_placed_order');
            Route::post('/change_order_status/{order_id}' , 'change_order_status');
            //Route::post('/check_coupon' , 'check_valid_coupon');
        });

    Route::controller(AddressController::class)
        ->middleware('auth:sanctum')->group(function (){
            Route::post('/save_address','save_address');
            Route::post('/make_primary/{address_id}','make_primary');
            Route::get('/show_addresses','show_addresses');
            Route::post('/edit_address/{address_id}','edit_address');
            Route::delete('/delete_address/{address_id}','delete_address');
        });

    Route::controller(WishlistController::class)
        ->middleware('auth:sanctum')->group(function(){
           Route::post('/add_product_to_wishlist/{product_id}' , 'add_product_to_wishlist');
           Route::post('/add_offer_to_wishlist/{offer_id}' , 'add_offer_to_wishlist');
           Route::get('/show_wishlist' , 'show_wishlist');
           Route::delete('/remove_from_wishlist/{id}' , 'remove_from_wishlist');
        });

    Route::controller(ProductController::class)->group(function (){
        Route::get('/all_product' , 'show_all_products')->name('get_all_products');
        Route::post('/create_product' , 'create_product')->name('create_product');
        Route::get('/show_product/{product_id}' , 'show_product')->name('show_one_product');
        Route::post('/update_product/{product_id}' , 'update_product')->name('update_product');
        Route::delete('/destroy_product/{product_id}' , 'delete_product')->name('delete_product');
        Route::get('/get_products_by_category/{category_id}' , 'get_products_by_category')->name('get_products_by_category');
        Route::get('/get_products_by_brand/{brand_id}' , 'get_products_by_brand')->name('get_products_by_brand');
        Route::post('/search/product' , 'search_products')->name('search_product');
        Route::get('/getPopular/{id}' , 'get_popular_products')->name('getPopular_product');
        Route::get('/get_products_by_category_and_brand/{category_id}/{brand_id?}' , 'get_products_by_category_and_brand')->name('get_products_by_category_and_brand');
      });
    Route::controller(CategoryController::class)->group(function (){
        Route::get('/all_category' , 'show_all_categories')->name('get_all_categories');
        Route::post('/create_category' , 'create_category')->name('create_category');
        Route::get('/show_category/{category_id}' , 'show_category')->name('show_one_category');
        Route::post('/update_category/{category_id}' , 'update_category')->name('update_category');
        Route::delete('/destroy_category/{category_id}' , 'delete_category')->name('delete_category');
        Route::post('/search/category' , 'search_by_category')->name('search_category');
      });
    Route::controller(BrandController::class)->group(function (){
        Route::get('/all_brand' , 'show_all_brands')->name('get_all_brands');
        Route::post('/create_brand' , 'create_brand')->name('create_brand');
        Route::get('/show_brand/{brand_id}' , 'show_brand')->name('show_one_brand');
        Route::post('/update_brand/{brand_id}' , 'update_brand')->name('update_brand');
        Route::delete('/destroy_brand/{brand_id}' , 'delete_brand')->name('delete_brand');
        Route::post('/search_brand' , 'search_by_brand')->name('search_brand');
        Route::get('brands/{category_id}', 'get_brand_by_category');
      });

    Route::controller(TransactionController::class)
        ->middleware('auth:sanctum')->group(function(){
            Route::get('/my_transactions' , 'show_my_transactions');
            Route::get('/user_transactions/{user_id}' , 'show_user_transactions');
            Route::get('/all_transactions' , 'show_all_transactions');
        });

    Route::controller(WalletController::class)
        ->middleware('auth:sanctum')->group(function (){
            Route::get('/my_wallet' , 'show_my_wallet');
            Route::get('/user_wallet/{user_id}' , 'show_user_wallet');
        });

    Route::controller(CouponController::class)
        ->middleware('auth:sanctum')->group(function(){
           Route::get('/coupons' , 'show_all_coupons');
           Route::get('/coupon/{coupon_id}' , 'show_coupon');
           Route::post('/create_coupon' , 'create_coupon');
           Route::post('/update_coupon/{coupon_id}' , 'update_coupon');
           Route::delete('/delete_coupon/{coupon_id}' , 'delete_coupon');
        });

    Route::controller(TradeCenterController::class)
        ->middleware('auth:sanctum')->group(function (){
            Route::post('/trade_page' , 'show_trade_page');
            Route::post('/trade_product' , 'trade_product');
            Route::post('/edit_trade_product/{trade_id}' , 'edit_trade_product');
            Route::post('/update_trade_status/{trade_id}' , 'change_trade_status');
            Route::post('/cancel_trade_product/{trade_id}' , 'cancel_trade_product');
        });
    Route::controller(RepairingCenterController::class)
        ->middleware('auth:sanctum')->group(function (){
            Route::post('/repair_product' , 'repair_product');
            Route::post('/edit_repair_product/{trade_id}' , 'edit_repair_product');
            Route::post('/update_repair_status/{trade_id}' , 'change_repair_order_status');
            Route::post('/cancel_repair_product/{trade_id}' , 'cancel_repair_order');
        });
Route::post('create/products/{productId}/photos', [ProductPhotoController::class, 'create']);
//Route::put('update/product-photos/{id}', [ProductPhotoController::class, 'update']);
Route::delete('delete/product-photos/{id}', [ProductPhotoController::class, 'destroy']);
Route::get('getone/product-photos/{id}', [ProductPhotoController::class, 'show']);
Route::get('products/{productId}/getphotosbyproduct', [ProductPhotoController::class, 'getPhotosByProduct']);
