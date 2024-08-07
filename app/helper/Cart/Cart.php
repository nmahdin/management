<?php

namespace App\helper\Cart;

use Illuminate\Support\Facades\Facade;

/**
 * @method static put(array $array , $obj)
 * @method static get(int $int)
 * @method static has(\App\Models\Product $product)
 * @method static all()
 * @method static count()
 * @method static update()
 * @method static delete($id)
 */
class Cart extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'cart';
    }
}
