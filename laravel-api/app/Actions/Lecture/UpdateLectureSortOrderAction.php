<?php

namespace App\Actions\Lecture;

use App\Models\Course;
use App\Models\Section;

class UpdateLectureSortOrderAction
{
    public static function run(Course $course, array $payload)
    {
        foreach ($payload as $item) {
            $section = Section::getId($item['section']);
            $course->lectures()->hashid($item['id'])->first()->update([
                'section_id' => $section,
                'sort_order' => $item['sort_order'],
            ]);
        }
    }
}
