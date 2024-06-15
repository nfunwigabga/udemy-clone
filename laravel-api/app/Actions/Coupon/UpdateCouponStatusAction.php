<?php

namespace App\Actions\Coupon;

use App\Models\Coupon;

class UpdateCouponStatusAction
{
    public static function run(Coupon $coupon)
    {
        $coupon->update([
            'active' => ! $coupon->active,
        ]);
    }
}
