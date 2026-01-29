<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Setting;
use App\Models\Category;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register PaymentManager as singleton
        $this->app->singleton(\App\Services\Payment\PaymentManager::class, function ($app) {
            return new \App\Services\Payment\PaymentManager();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (Schema::hasTable('settings') && Schema::hasTable('categories')) {
            $settings = Setting::all()->pluck('value', 'key')->toArray();
            $categories_global = Category::where('is_active', true)->get();
            
            View::share('settings', $settings);
            View::share('categories_global', $categories_global);
            
            // Share cart and wishlist counts globally
            View::composer('*', function ($view) {
                $view->with('cart_count', count(session()->get('cart', [])));
                $view->with('wishlist_count', count(session()->get('wishlist', [])));
            });
        }
        \Illuminate\Support\Facades\Schema::defaultStringLength(191);
    }
}
