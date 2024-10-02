<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WishlistController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
    Route::get('reset_password' , 'reset_password')->name('user.reset_password');

    Route::get('auth/google' , 'redirect_to_google');
    Route::get('auth/google/callback' , 'google_handle_call_back');

      Route::group(['middleware' => ['auth:sanctum']] , function (){
        Route::prefix('profile')->group(function (){
        Route::get('/all' , 'show_all_profiles');
        Route::get('/show/{id}' , 'show_user_profile');
        Route::post('/update' , 'update_profile');
        Route::post('password/update' , 'update_password');
        Route::delete('/delete' , 'delete_my_profile');
        Route::delete('/delete/{id}' , 'delete_profile');
        });
    });
});

Route::post('/email/verification-notification' , function (Request $request){
        $request->user()->sendEmailVerificationNotification();
    return response()->json(['message' => 'new verification link sent!']);
})->middleware(['auth:sanctum' , 'throttle:6,1'])->name('verification.send');

Route::controller(CartController::class)
    ->middleware('auth:sanctum')->group(function (){
    Route::get('/cart', 'show_cart');
    Route::delete('/cart/delete/{product_id}', 'delete_from_cart');
    Route::post('/add_to_cart/{product_id}', 'add_to_cart');
});


Route::controller(OrderController::class)
    ->middleware('auth:sanctum')->group(function(){
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
