<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Support\Facades\Gate;

class CourseEnrollmentController extends Controller
{
    public function checkIfUserCanAccessCourse(Course $course)
    {
        return response()->json([
            'can' => Gate::allows('view', $course),
        ]);
    }
}
