<?php

namespace App\Actions\Coupon;

use App\Data\Coupon\StoreCouponData;
use App\Models\Course;

class StoreCouponAction
{
    public static function run(StoreCouponData $data, Course $course)
    {
        return $course->coupons()->create([
            'code' => $data->code,
            'percent' => $data->percent,
            'expires_at' => $data->expires_at,
            'quantity' => $data->quantity,
            'active' => true,
        ]);
    }
}
