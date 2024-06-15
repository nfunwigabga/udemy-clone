<?php

namespace App\Models;

class CartItem extends BaseModel
{
    // public $keyPrefix = '';

    protected $fillable = [
        'cart_id',
        'coupon_id',
        'course_id',
        'price',
        'discount_price',

    ];

    
}
