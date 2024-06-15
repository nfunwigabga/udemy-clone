<?php

namespace App\Data\Cart;

use Spatie\LaravelData\Data;

class AddCourseToCartData extends Data
{
    public string $course;

    public ?string $coupon;

    public static function rules(): array
    {
        return [

        ];
    }
}
