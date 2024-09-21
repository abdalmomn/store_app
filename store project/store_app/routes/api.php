<?php

use App\Http\Controllers\AuthController;
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

    Route::get('/all_profiles' , 'show_all_profiles');
    Route::get('/profile/{id}' , 'show_user_profile');
});


Route::post('/email/verification-notification' , function (Request $request){
        $request->user()->sendEmailVerificationNotification();
    return response()->json(['message' => 'new verification link sent!']);
})->middleware(['auth:sanctum' , 'throttle:6,1'])->name('verification.send');
