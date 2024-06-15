<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lecture;
use App\Http\Resources\CourseResource;
use App\Http\Resources\LectureResource;
use App\Actions\Course\GetLatestCoursesAction;

class CourseController extends Controller
{
    public function index()
    {
        $courses = GetLatestCoursesAction::run();

        return CourseResource::collection($courses);
    }
    
    public function show(Course $course)
    {
        return CourseResource::make($course->load(['category', 'sections.lectures', 'targets']));
    }

    public function learn(Course $course, Lecture $lecture)
    {
        $this->authorize('view', $course);
        $next = $lecture->getNext();
        $previous = $lecture->getPrevious();

        return response()->json([
            'course' => CourseResource::make($course->load(['sections.lectures'])),
            'lecture' => LectureResource::make($lecture),
            'can' => \Auth::user()?->canAccessCourse($course),
            'next' => $next,
            'previous' => $previous,
        ]);
    }

    public function overview(Course $course)
    {
        return CourseResource::make($course->load(['author']));
    }
}
