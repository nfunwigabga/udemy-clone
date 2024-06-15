<?php

namespace App\Actions\Course;

use App\Models\Course;

class UpdateCourseStatusAction
{
    public static function run(Course $course)
    {
        return tap($course)->update([
            'published_at' => $course->isPublished() ? null : now(),
        ]);
    }
}
