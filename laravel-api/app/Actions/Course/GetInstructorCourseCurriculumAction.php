<?php

namespace App\Actions\Course;

use App\Http\Resources\CourseResource;
use App\Models\Course;

class GetInstructorCourseCurriculumAction
{
    public static function run(Course $course)
    {
        return CourseResource::make(
            $course->fresh()->load(['sections', 'sections.lectures'])
        );
    }
}
