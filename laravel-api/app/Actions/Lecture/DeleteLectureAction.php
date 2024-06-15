<?php

namespace App\Actions\Lecture;

use App\Models\Lecture;

class DeleteLectureAction
{
    public static function run(Lecture $lecture)
    {
        if ($lecture->video()->exists()) {
            $lecture->video->delete();
        }

        $lecture->delete();
    }
}
