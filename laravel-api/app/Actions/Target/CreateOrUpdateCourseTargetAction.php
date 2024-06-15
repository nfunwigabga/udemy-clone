<?php

namespace App\Actions\Target;

use App\Data\Target\CourseTargetData;
use App\Models\Course;
use App\Models\Target;
use Illuminate\Support\Arr;

class CreateOrUpdateCourseTargetAction
{
    public static function run(Course $course, CourseTargetData $data)
    {
        foreach ($data as $type => $items) {
            $filtered = Arr::where(data_get($items, '*.id'), fn ($value, $key) => $value != null);

            foreach ($items as $item) {
                if ($item['id'] == null) {
                    $maxSort = $course->targets()->type($type)->max('sort_order');
                    $target = $course->targets()->create([
                        'type' => $type,
                        'text' => $item['text'],
                        'sort_order' => $maxSort + 1,
                    ]);
                    $filtered[] = $target->hashid;
                } else {
                    $target = Target::find(Target::getId($item['id']));
                    $target->update([
                        'text' => $item['text'],
                    ]);
                }
            }

            $course->targets()
                ->type($type)
                ->whereNotIn('hashid', $filtered)
                ->delete();
        }
    }
}
