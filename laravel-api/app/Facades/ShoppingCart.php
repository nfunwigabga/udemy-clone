<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static getCurrent()
 * @method static current()
 * @method static add(\App\Models\Course $param)
 * @method static remove(\App\Models\Course $param)
 * @method static clear()
 * @method static applyDiscountToCartItem()
 */
class ShoppingCart extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'cart';
    }
}
