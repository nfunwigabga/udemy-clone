<?php

namespace App\Actions\Lecture;

use App\Data\Lecture\CourseLectureData;
use App\Models\Lecture;

class UpdateLectureAction
{
    public static function run(CourseLectureData $data, Lecture $lecture)
    {
        return tap($lecture)->update([
            'title' => $data->title,
        ]);
    }
}
