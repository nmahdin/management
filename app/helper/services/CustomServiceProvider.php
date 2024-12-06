<?php

namespace App\helper\services;

use Illuminate\Support\ServiceProvider;

class CustomServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('custom' , function () {
            return new CustomService();
        });

    }
}
