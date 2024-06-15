<?php

namespace App\Actions\Section;

use App\Data\Section\CourseSectionData;
use App\Models\Course;

class StoreSectionAction
{
    public static function run(CourseSectionData $data, Course $course)
    {
        $maxSort = $course->sections()->max('sort_order');

        return $course->sections()->create([
            'title' => $data->title,
            'sort_order' => $maxSort + 1,
        ]);
    }
}
