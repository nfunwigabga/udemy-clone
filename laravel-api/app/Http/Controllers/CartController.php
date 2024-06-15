<?php

namespace App\Http\Controllers;

use App\Facades\ShoppingCart;
use App\Models\Course;

class CartController extends Controller
{
    public function index()
    {
        return ShoppingCart::getCurrent();
    }

    public function add()
    {
        return ShoppingCart::add(new Course());
    }

    public function remove()
    {
        return ShoppingCart::remove(new Course());
    }

    public function clear()
    {
        return ShoppingCart::clear();
    }

    public function applyCoupon()
    {
        return ShoppingCart::applyDiscountToCartItem();
    }
}
