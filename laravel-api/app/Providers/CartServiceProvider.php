<?php

namespace App\Providers;

use App\Services\CartService;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('cart', function () {
            return new CartService();
        });
    }

    public function boot(): void
    {
        //
    }
}
