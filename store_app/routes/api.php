<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
  use App\Http\Controllers\Api\BrandController;
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
        Route::post('/update/{id}' , 'update_profile');
        Route::post('password/update' , 'update_password');
        Route::delete('/delete/{id}' , 'delete_profile');
      });
    });
});


Route::post('/email/verification-notification' , function (Request $request){
        $request->user()->sendEmailVerificationNotification();
    return response()->json(['message' => 'new verification link sent!']);
})->middleware(['auth:sanctum' , 'throttle:6,1'])->name('verification.send');

//crud products
Route::controller(ProductController::class)->group(function (){
    Route::get('/all_product' , 'index')->name('get_all_products');
    Route::post('/create_product' , 'create')->name('create_product');
    Route::get('/show_product/{id}' , 'show')->name('show_one_product');
    Route::post('/update_product/{id}' , 'update')->name('update_product');
    Route::delete('/destroy_product/{id}' , 'destroy')->name('delete_product');
    Route::post('/search/product' , 'search')->name('search_product');
    Route::get('/getPopular/{id}' , 'getPopular')->name('getPopular_product');
    Route::get('/getProductsByCategoryAndBrand/{categoryId}/{brandid?}' , 'getProductsByCategoryAndBrand')->name('getByCategory');
  });
Route::controller(CategoryController::class)->group(function (){
    Route::get('/all_category' , 'index')->name('get_all_categories');
    Route::post('/create_category' , 'create')->name('create_category');
    Route::get('/show_category/{id}' , 'show')->name('show_one_category');
    Route::post('/update_category/{id}' , 'update')->name('update_category');
    Route::delete('/destroy_category/{id}' , 'destroy')->name('delete_category');
    Route::post('/search/category' , 'search')->name('search_category');
  });
Route::controller(BrandController::class)->group(function (){
    Route::get('/all_brand' , 'index')->name('get_all_brands');
    Route::post('/create_brand' , 'create')->name('create_brand');
    Route::get('/show_brand/{id}' , 'show')->name('show_one_brand');
    Route::post('/update_brand/{id}' , 'update')->name('update_brand');
    Route::delete('/destroy_brand/{id}' , 'destroy')->name('delete_brand');
    Route::post('/search_brand' , 'search')->name('search_brand');
    Route::get('brands/{category}/by-category', 'getByCategory');
  });
