<?php

namespace App\Actions\Target;

use App\Models\Course;

class GetCourseTargetsAction
{
    public static function run(Course $course)
    {
        return $course->targets()->get();
    }
}
