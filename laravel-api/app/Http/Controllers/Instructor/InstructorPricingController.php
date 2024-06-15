<?php

namespace App\Http\Controllers\Instructor;

use App\Actions\Coupon\StoreCouponAction;
use App\Actions\Coupon\UpdateCouponStatusAction;
use App\Actions\Pricing\UpdateCoursePriceAction;
use App\Data\Coupon\StoreCouponData;
use App\Data\Pricing\UpdateCoursePriceData;
use App\Http\Controllers\Controller;
use App\Http\Resources\CouponResource;
use App\Http\Resources\CourseResource;
use App\Models\Coupon;
use App\Models\Course;

class InstructorPricingController extends Controller
{
    public function index(Course $course)
    {
        return response()->json([
            'course' => CourseResource::make($course),
            'coupons' => CouponResource::collection($course->coupons),
            'price_tiers' => config('site.price_tiers'),
        ]);
    }

    public function updatePrice(UpdateCoursePriceData $data, Course $course)
    {
        UpdateCoursePriceAction::run($data, $course);

        return CourseResource::make($course);
    }

    public function storeCoupon(StoreCouponData $data, Course $course)
    {
        $coupon = StoreCouponAction::run($data, $course);

        return CouponResource::make($coupon);
    }

    public function updateCouponStatus(Course $course, Coupon $coupon)
    {
        UpdateCouponStatusAction::run($coupon);

        return CouponResource::make($coupon->fresh());
    }
}
