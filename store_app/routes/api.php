<?php

<<<<<<< HEAD
=======
use App\Http\Controllers\AddressController;
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
<<<<<<< HEAD
use App\Http\Controllers\OfferController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductPhotoController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\TransactionController;
=======
use App\Http\Controllers\CouponController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductPhotoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RepairingCenterController;
use App\Http\Controllers\TradeCenterController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WalletController;
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
use App\Http\Controllers\WishlistController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

<<<<<<< HEAD

=======
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
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

<<<<<<< HEAD
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
=======
//unauthenticated APIs

    Route::controller(AuthController::class)->group(function (){
        Route::post('client_register' , 'register_as_client');
        Route::post('seller_register' , 'register_as_seller')->name('user.seller_register');
        Route::post('login' , 'login')->name('user.login');

        Route::get('forget_password' , 'forget_password')->name('user.forget_password');
        Route::get('check_code' , 'check_code')->name('user.check_code');
        Route::post('resend_code' , 'resend_code')->name('user.resend_code');
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
        Route::get('reset_password' , 'reset_password')->name('user.reset_password');

        Route::get('auth/google' , 'redirect_to_google');
        Route::get('auth/google/callback' , 'google_handle_call_back');
<<<<<<< HEAD

    Route::group(['middleware' => ['auth:sanctum']] , function (){
        Route::prefix('profile')->group(function (){
=======
        Route::get('auth/apple' , 'redirect_to_apple');
        Route::get('auth/apple/callback' , 'apple_handle_call_back');
    });

    //verification email
    Route::post('/email/verification-notification' , function (Request $request){
        $request->user()->sendEmailVerificationNotification();
        return response()->json(['message' => 'new verification link sent!']);
    })->middleware(['auth:sanctum' , 'throttle:60,1'])->name('verification.send');


    //unauthenticated APIs for guest
    Route::controller(ProductController::class)->group(function(){
        Route::get('/all_product' , 'show_all_products')->name('get_all_products');
        Route::get('/show_product/{product_id}' , 'show_product')->name('show_one_product');
        Route::get('/get_products_by_category/{category_id}' , 'get_products_by_category')->name('get_products_by_category');
        Route::get('/get_products_by_brand/{brand_id}' , 'get_products_by_brand')->name('get_products_by_brand');
        Route::post('/search/product' , 'search_products')->name('search_product');
        Route::get('/getPopular/{id}' , 'get_popular_products')->name('getPopular_product');
        Route::get('/get_products_by_category_and_brand/{category_id}/{brand_id?}' , 'get_products_by_category_and_brand')->name('get_products_by_category_and_brand');
    });

    Route::controller(CategoryController::class)->group(function(){
        Route::get('/all_category' , 'show_all_categories')->name('get_all_categories');
        Route::get('/show_category/{category_id}' , 'show_category')->name('show_one_category');
        Route::post('/search/category' , 'search_by_category')->name('search_category');
    });

    Route::controller(BrandController::class)->group(function(){
        Route::get('/all_brand' , 'show_all_brands')->name('get_all_brands');
        Route::get('/show_brand/{brand_id}' , 'show_brand')->name('show_one_brand');
        Route::post('/search_brand' , 'search_by_brand')->name('search_brand');
        Route::get('brands/{category_id}', 'get_brand_by_category');
    });

    Route::controller(ProductPhotoController::class)->group(function(){
        Route::get('getone/product-photos/{id}' , 'show');
        Route::get('products/{productId}/getphotosbyproduct' , 'getPhotosByProduct');
    });

    Route::post('/trade_page' , [TradeCenterController::class,'show_trade_page']);


//authentication APIs
Route::middleware('auth:sanctum')->group(function(){

    Route::get('logout' , [AuthController::class , 'logout'])->name('user.logout');

    Route::controller(ProfileController::class)->group(function (){
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
        Route::get('/all' , 'show_all_profiles');
        Route::get('/show/{id}' , 'show_user_profile');
        Route::post('/update' , 'update_profile');
        Route::post('password/update' , 'update_password');
        Route::delete('/delete' , 'delete_my_profile');
        Route::delete('/delete/{id}' , 'delete_profile');
<<<<<<< HEAD
          });
        });
    });

    Route::post('/email/verification-notification' , function (Request $request){
            $request->user()->sendEmailVerificationNotification();
        return response()->json(['message' => 'new verification link sent!']);
    })->middleware(['auth:sanctum' , 'throttle:6,1'])->name('verification.send');

    Route::controller(CartController::class)
        ->middleware('auth:sanctum')->group(function (){
=======
    });

    Route::controller(CartController::class)->group(function (){
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
        Route::get('/cart', 'show_cart');
        Route::delete('/cart/delete/{product_id}', 'delete_from_cart');
        Route::post('/add_to_cart/{product_id}', 'add_to_cart');
    });

<<<<<<< HEAD

    Route::controller(OrderController::class)
        ->middleware('auth:sanctum')->group(function(){
            Route::post('/save_address','save_address');
            Route::post('/make_primary/{address_id}','make_primary');
            Route::get('/show_addresses','show_addresses');
            Route::post('/edit_address/{address_id}','edit_address');
            Route::delete('/delete_address/{address_id}','delete_address');
            Route::get('/delivery/{cart_id}' , 'deliver_to_my_address');
        });

    Route::controller(WishlistController::class)
        ->middleware('auth:sanctum')->group(function(){
           Route::post('/add_product_to_wishlist/{product_id}' , 'add_product_to_wishlist');
           Route::post('/add_offer_to_wishlist/{offer_id}' , 'add_offer_to_wishlist');
           Route::get('/show_wishlist' , 'show_wishlist');
           Route::delete('/remove_from_wishlist/{id}' , 'remove_from_wishlist');
        });
    //crud products
    Route::controller(ProductController::class)->group(function (){
        Route::get('/AllProduct' , 'GetAllProducts');
        Route::post('/CreateProduct' , 'CreateProduct');
        Route::get('/ShowOneProduct/{ProductId}' , 'GetOneProduct');
        Route::post('/UpdateProduct/{ProductId}' , 'UpdateProduct');
        Route::delete('/DestroyProduct/{Productid}' , 'DestroyProduct');
        Route::post('/Search/Product' , 'SearchProduct');
        Route::get('/GetPopular/{ProductId}' , 'GetPapular');
        Route::get('/GetProductsByCategoryAndBrand/{CategoryId}/{BrandId?}' , 'GetProductsByCategoryAndBrand');
      });
    Route::controller(CategoryController::class)->group(function (){
        Route::get('/AllCategory' , 'GetAllCategories')->name('get_all_categories');
        Route::post('/CreateCategory' , 'CreateCategory')->name('create_category');
        Route::get('/ShowCategory/{CategoryId}' , 'GetOneCategory')->name('show_one_category');
        Route::post('/UpdateCategory/{CategoryId}' , 'UpdateCategory')->name('update_category');
        Route::delete('/DestroyCategory/{CategoryId}' , 'DestroyCategory')->name('delete_category');
        Route::post('/Search/Category' , 'search')->name('SearchCategory');
      });
    Route::controller(BrandController::class)->group(function (){
        Route::get('/AllBrand' , 'GetAllBrand')->name('get_all_brands');
        Route::post('/CreateBrand' , 'CreateBrand')->name('create_brand');
        Route::get('/ShowBrand/{BrandId}' , 'GetOneBrand')->name('show_one_brand');
        Route::post('/UpdateBrand/{BrandIdd}' , 'UpdateBrand')->name('update_brand');
        Route::delete('/DestroyBrand/{BrandId}' , 'DestroyBrand')->name('delete_brand');
        Route::post('/SearchBrand' , 'SearchForBrand')->name('search_brand');
        Route::get('Brands/{categoryId}', 'GetBrandByCategory');
      });

    Route::controller(TransactionController::class)
        ->middleware('auth:sanctum')->group(function(){
            Route::get('/my_wallet' , 'show_my_wallet');
            Route::get('/user_wallet/{user_id}' , 'show_user_wallet');
        });
Route::post('Create/Products/{ProductId}/Photos', [ProductPhotoController::class, 'CreatePhotoesProduct']);
Route::delete('Delete/Product-Photos/{ProductId}', [ProductPhotoController::class, 'DeletePhotoesProduct']);
Route::get('GetOne/ProductPhotos/{ProductId}', [ProductPhotoController::class, 'ShowOnePhotoesProduct']);
Route::get('Products/{ProductId}/GetPhotosByProduct', [ProductPhotoController::class, 'GetPhotosByProduct']);


Route::prefix('offers')->controller(OfferController::class)->group(function () {
    Route::get('/GetAllOffer', 'ShowAllOffers');
    Route::post('/CreateOffer', 'CreateOffer');
    Route::get('/ShowOneOffer/{OfferId}','ShowOneOffer');
    Route::post('/Update/{OfferId}', 'UpdateOffer');
    Route::delete('/Delete/{OfferId}', 'DestroyOffer');
    Route::post('/SearchOffer' , 'SearchOffer');
    Route::post('/{OfferId}/AddProducts', 'AddProductsForOffer');

});
    Route::post('/reviews/create', [ReviewController::class, 'CreateReview']);
    Route::post('/reviews/{ReviewId}', [ReviewController::class, 'UpdateReview']);
    Route::delete('/reviews/delete/{ReviewId}', [ReviewController::class, 'DestroyReview']);
    Route::get('/reviews', [ReviewController::class, 'GetAllReviews']);
    Route::get('/reviews/show/{ReviewId}', [ReviewController::class, 'GetOneReview']);
    Route::get('/GetReviews/ByProduct/{productId}', [ReviewController::class, 'GetByProductId']);
    Route::get('/users/{UserId}/reviews', [ReviewController::class, 'GetByUserId']);
    Route::get('/products/{productId}/comments', [ReviewController::class, 'SortCommentsByTime']);
    Route::get('/products/{productId}/CommentsByMostLikes', [ReviewController::class, 'GetCommentsByMostLikes']);
Route::get('/products/{productId}/CommentsByLessLikes', [ReviewController::class, 'GetCommentsByLessLikes']);
Route::get('/reviews/addlikeOrDisLikeTo/{reviewId}/byuser/{userId}',[ReviewController::class, 'AddDislikeOrDislike']);
Route::get('/reviews/deleteLikeOrDislike/{reviewId}/byuser/{userId}',[ReviewController::class, 'DeleteLikeOrDislike']);
=======
    Route::controller(OrderController::class)->group(function(){
        Route::post('/checkout' , 'checkout');
        Route::post('/place_order' , 'place_order');
        Route::get('/cancel_placed_order/{order_id}' , 'cancel_placed_order');
        Route::post('/change_order_status/{order_id}' , 'change_order_status');
    });

    Route::controller(AddressController::class)->group(function (){
        Route::post('/save_address','save_address');
        Route::post('/make_primary/{address_id}','make_primary');
        Route::get('/show_addresses','show_addresses');
        Route::post('/edit_address/{address_id}','edit_address');
        Route::delete('/delete_address/{address_id}','delete_address');
    });

    Route::controller(WishlistController::class)->group(function(){
        Route::post('/add_product_to_wishlist/{product_id}' , 'add_product_to_wishlist');
        Route::post('/add_offer_to_wishlist/{offer_id}' , 'add_offer_to_wishlist');
        Route::get('/show_wishlist' , 'show_wishlist');
        Route::delete('/remove_from_wishlist/{id}' , 'remove_from_wishlist');
    });

    Route::controller(ProductController::class)->group(function (){
        Route::post('/create_product' , 'create_product')->name('create_product');
        Route::post('/update_product/{product_id}' , 'update_product')->name('update_product');
        Route::delete('/destroy_product/{product_id}' , 'delete_product')->name('delete_product');

    });

    Route::controller(CategoryController::class)->group(function (){
        Route::post('/create_category' , 'create_category')->name('create_category');
        Route::post('/update_category/{category_id}' , 'update_category')->name('update_category');
        Route::delete('/destroy_category/{category_id}' , 'delete_category')->name('delete_category');
    });

    Route::controller(BrandController::class)->group(function (){
        Route::post('/create_brand' , 'create_brand')->name('create_brand');
        Route::post('/update_brand/{brand_id}' , 'update_brand')->name('update_brand');
        Route::delete('/destroy_brand/{brand_id}' , 'delete_brand')->name('delete_brand');
    });

    Route::controller(TransactionController::class)->group(function(){
        Route::get('/my_transactions' , 'show_my_transactions');
        Route::get('/user_transactions/{user_id}' , 'show_user_transactions');
        Route::get('/all_transactions' , 'show_all_transactions');
    });

    Route::controller(WalletController::class)->group(function (){
        Route::get('/my_wallet' , 'show_my_wallet');
        Route::get('/user_wallet/{user_id}' , 'show_user_wallet');
    });

    Route::controller(CouponController::class)->group(function(){
        Route::get('/coupons' , 'show_all_coupons');
        Route::get('/coupon/{coupon_id}' , 'show_coupon');
        Route::post('/create_coupon' , 'create_coupon');
        Route::post('/update_coupon/{coupon_id}' , 'update_coupon');
        Route::delete('/delete_coupon/{coupon_id}' , 'delete_coupon');
    });

    Route::controller(TradeCenterController::class)->group(function (){
        Route::post('/trade_product' , 'trade_product');
        Route::post('/edit_trade_product/{trade_id}' , 'edit_trade_product');
        Route::post('/update_trade_status/{trade_id}' , 'change_trade_status');
        Route::post('/cancel_trade_product/{trade_id}' , 'cancel_trade_product');
    });

    Route::controller(RepairingCenterController::class)->group(function (){
        Route::post('/repair_product' , 'repair_product');
        Route::post('/edit_repair_product/{trade_id}' , 'edit_repair_product');
        Route::post('/update_repair_status/{trade_id}' , 'change_repair_order_status');
        Route::post('/cancel_repair_product/{trade_id}' , 'cancel_repair_order');
    });

    //must be edited
    Route::controller(ProductPhotoController::class)->group(function(){
        Route::post('create/products/{productId}/photos' , 'create');
        Route::put('update/products/{productId}/photos' , 'update');
        Route::delete('delete/product-photos/{id}' , 'destroy');
    });
});




>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8

