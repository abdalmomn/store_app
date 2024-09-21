<?php

use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
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

Route::get('/', function () {
    return view('welcome');
});

//basic auth

Route::controller(AuthController::class)->group(function(){
    Route::post('/' , 'index')->name('index');
    Route::get('password/forget',  'showForgetPasswordForm')->name('password.forget');
    Route::post('password/email', 'forget_password')->name('password.email');
    Route::get('password/resendCode',  'resend_code')->name('password.resend');
    Route::get('password/code',  'showCheckCodeForm')->name('password.code');

    Route::post('password/check_code', 'check_code')->name('password.check_code');
    Route::get('password/reset', 'showResetPasswordForm')->name('password.reset');
    Route::post('password/update', 'reset_password')->name('password.update');

//login by google
    Route::get('auth/google', 'redirect_to_google');
    Route::get('auth/google/callback', 'google_handle_call_back');
});


//email verification
Route::get('/email/verify', function () {
    return view('verify-email');
})->middleware('auth:sanctum')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/');
})->middleware(['auth:sanctum', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth:sanctum', 'throttle:6,1'])->name('verification.send');
