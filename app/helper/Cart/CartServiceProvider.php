<?php

namespace App\helper\Cart;

use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('cart' , function () {
            return new CartService();
        });

    }
}
