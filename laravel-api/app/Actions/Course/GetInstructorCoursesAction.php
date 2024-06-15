<?php

namespace App\Actions\Course;

use Illuminate\Support\Facades\Auth;

class GetInstructorCoursesAction
{
    public static function run()
    {
        return Auth::user()->courses;
    }
}
