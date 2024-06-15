<?php

namespace App\Actions\Section;

use App\Models\Course;

class ReorderCourseSectionsAction
{
    public static function run(Course $course)
    {
        $sections = $course->sections()->orderBy('sort_order')->get();

        $sections->each(function ($section, $index) {
            $section->update(['sort_order' => $index + 1]);
        });
    }
}
