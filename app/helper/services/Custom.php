<?php

namespace App\helper\services;

use Illuminate\Support\Facades\Facade;

class Custom extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'custom';
    }
}

