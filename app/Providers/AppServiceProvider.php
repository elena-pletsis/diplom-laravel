<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Brand;
use App\Category;
use App\Product;
use App\Wishlist;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        $Category = new Category;
        $mainCategoriesProvider = $Category->mainCategories()->get();
        View::share('brandsProvider', Brand::all());
        View::share('mainCategoriesProvider', $mainCategoriesProvider);
        View::share('productsProvider', Product::all());
        View::share('wishProductsProvider', Wishlist::all());

    }
}
