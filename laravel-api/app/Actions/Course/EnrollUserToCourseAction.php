<?php

namespace App\Actions\Course;

use App\Models\Course;
use Illuminate\Contracts\Auth\Authenticatable;

class EnrollUserToCourseAction
{
    public static function run(User|Authenticatable $user, Course $course)
    {
        $course->students()->attach($user);
    }
}
