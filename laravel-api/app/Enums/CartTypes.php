<?php

namespace App\Enums;

enum CartTypes: string
{
    case SHOPPING_CART = 'shopping_cart';
    case WISHLIST = 'wishlist';

    public function getDescriptions(): string
    {
        return match ($this) {
            self::SHOPPING_CART => "User's shopping cart",
            self::WISHLIST => "User's wishlist"
        };
    }
}
