<?php

namespace App\Actions\Course;

use App\Models\Course;

class GetLatestCoursesAction
{
    public static function run()
    {
        return Course::published()
            ->with('author')
            ->latest()
            ->get();
    }
}
