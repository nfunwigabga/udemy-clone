<?php

namespace App\Actions\Lecture;

use App\Models\Course;

class ReorderCourseLecturesAction
{
    public static function run(Course $course)
    {
        $lectures = $course->lectures()
                        ->join('sections', 'sections.id', '=', 'lectures.section_id')
                        ->orderBy('sections.sort_order')
                        ->orderBy('lectures.sort_order')
                        ->select('lectures.*')
                        ->get();

        $lectures->each(function ($lecture, $index) {
            $lecture->update(['sort_order' => $index + 1]);
        });
    }
}
