<?php

namespace App\Actions\Lecture;

use App\Data\Lecture\CourseLectureData;
use App\Models\Course;
use App\Models\Section;

class StoreLectureAction
{
    public static function run(CourseLectureData $data, Course $course, Section $section)
    {
        $maxSort = $section->lectures()->max('sort_order');

        return $section->lectures()->create([
            'course_id' => $course->id,
            'title' => $data->title,
            'type' => null,
            'sort_order' => $maxSort + 1,
        ]);
    }
}
