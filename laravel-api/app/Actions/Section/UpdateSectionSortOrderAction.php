<?php

namespace App\Actions\Section;

use App\Models\Course;

class UpdateSectionSortOrderAction
{
    public static function run(Course $course, array $payload)
    {
        foreach ($payload as $item) {
            $course->sections()->hashid($item['id'])->first()->update([
                'sort_order' => $item['sort_order'],
            ]);
        }

        return $course->sections->load('lectures');
    }
}
