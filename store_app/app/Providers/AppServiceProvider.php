<?php

namespace App\Providers;
use App\Repositories\products\ProductPhotoRepositoryInterface;
use App\Repositories\products\ProductPhotoRepository;
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
        $this->app->bind(CouponsRepositoryInterface::class, CouponsRepository::class);
        $this->app->bind(TransactionsRepositoryInterface::class, TransactionsRepository::class);
        $this->app->bind(ProductPhotoRepositoryInterface::class, ProductPhotoRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
