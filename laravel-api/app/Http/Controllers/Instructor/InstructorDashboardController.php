<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class InstructorDashboardController extends Controller
{
    public function index()
    {
        return Redirect::to(route('instructor.courses.index'));
    }
}
