<?php

namespace App\Actions\Course;

use App\Data\Course\UploadCourseImageData;
use App\Models\Course;

class UploadCourseImageAction
{
    public static function run(UploadCourseImageData $data, Course $course)
    {
        tap($course->image, function ($previous) use ($data, $course) {
            $course->addMedia($data->cover_image)
                ->toMediaCollection('cover');
            if ($previous) {
                $previous->delete();
            }
        });

        return $course->fresh();
    }
}
