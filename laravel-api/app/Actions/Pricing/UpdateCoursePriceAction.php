<?php

namespace App\Actions\Pricing;

use App\Data\Pricing\UpdateCoursePriceData;
use App\Models\Course;

class UpdateCoursePriceAction
{
    public static function run(UpdateCoursePriceData $data, Course $course)
    {
        $course->update([
            'price' => $data->price,
        ]);
    }
}
