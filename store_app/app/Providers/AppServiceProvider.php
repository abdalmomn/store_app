<?php

namespace App\Providers;
use App\Repositories\products\ProductPhotoRepositoryInterface;
use App\Repositories\products\ProductPhotoRepository;
<<<<<<< HEAD
use App\Repositories\ProfileRepository;
use App\Repositories\brands\BrandRepository;
use App\Repositories\categories\CategoryRepository;
use App\Repositories\products\ProductRepository;
use App\Repositories\ProfileRepositoryInterface;
use App\Repositories\products\ProductRepositoryInterface;
use App\Repositories\categories\CategoryRepositoryInterface;
use App\Repositories\brands\BrandRepositoryInterface;
use App\Repositories\reviews\ReviewRepository;
use App\Repositories\reviews\ReviewRepositoryinterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\offers\OfferRepositoryInterface;
use App\Repositories\offers\OfferRepository;
=======
use App\Repositories\brands\BrandRepository;
use App\Repositories\brands\BrandRepositoryInterface;
use App\Repositories\categories\CategoryRepository;
use App\Repositories\categories\CategoryRepositoryInterface;
use App\Repositories\coupons\CouponsRepository;
use App\Repositories\coupons\CouponsRepositoryInterface;
use App\Repositories\products\ProductRepository;
use App\Repositories\products\ProductRepositoryInterface;
use App\Repositories\profile\ProfileRepository;
use App\Repositories\profile\ProfileRepositoryInterface;
use App\Repositories\transactions\TransactionsRepository;
use App\Repositories\transactions\TransactionsRepositoryInterface;
use Illuminate\Support\ServiceProvider;

>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProfileRepositoryInterface::class, ProfileRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(BrandRepositoryInterface::class, BrandRepository::class);
<<<<<<< HEAD
        $this->app->bind(ProductPhotoRepositoryInterface::class, ProductPhotoRepository::class);
        $this->app->bind(OfferRepositoryInterface::class, OfferRepository::class);
        $this->app->bind(ReviewRepositoryInterface::class, ReviewRepository::class);


=======
        $this->app->bind(CouponsRepositoryInterface::class, CouponsRepository::class);
        $this->app->bind(TransactionsRepositoryInterface::class, TransactionsRepository::class);
        $this->app->bind(ProductPhotoRepositoryInterface::class, ProductPhotoRepository::class);
>>>>>>> 05e578ca1106e4e7f9d0b835346a7eddcc967ac8

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
