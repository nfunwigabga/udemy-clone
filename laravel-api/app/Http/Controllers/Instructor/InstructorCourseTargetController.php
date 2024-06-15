<?php

namespace App\Http\Controllers\Instructor;

use App\Actions\Target\CreateOrUpdateCourseTargetAction;
use App\Actions\Target\DestroyCourseTargetAction;
use App\Actions\Target\GetCourseTargetsAction;
use App\Actions\Target\UpdateCourseTargetsAction;
use App\Data\Target\CourseTargetData;
use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Http\Resources\TargetResource;
use App\Models\Course;
use App\Models\Target;
use Illuminate\Http\Request;

class InstructorCourseTargetController extends Controller
{
    public function index(Course $course)
    {
        $targets = GetCourseTargetsAction::run($course);

        return [
            'course' => CourseResource::make($course),
            'targets' => TargetResource::collection($targets),
        ];
    }

    public function store(CourseTargetData $data, Course $course)
    {
        CreateOrUpdateCourseTargetAction::run($course, $data);

        return response()->json(null, 201);
    }

    public function update(Request $request, Course $course)
    {
        UpdateCourseTargetsAction::run($request->data);

        return response()->json(null, 200);
    }

    public function destroy(Target $target)
    {
        DestroyCourseTargetAction::run($target);

        return response()->json(null, 200);
    }
}
