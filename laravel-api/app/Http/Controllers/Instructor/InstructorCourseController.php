<?php

namespace App\Http\Controllers\Instructor;

use App\Actions\Category\GetAllCategoriesAction;
use App\Actions\Course\GetInstructorCourseCurriculumAction;
use App\Actions\Course\GetInstructorCoursesAction;
use App\Actions\Course\StoreCourseAction;
use App\Actions\Course\UpdateCourseAction;
use App\Actions\Course\UpdateCourseStatusAction;
use App\Actions\Course\UploadCourseImageAction;
use App\Data\Course\StoreCourseData;
use App\Data\Course\UpdateCourseData;
use App\Data\Course\UploadCourseImageData;
use App\Enums\CourseLevel;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CourseResource;
use App\Models\Course;

class InstructorCourseController extends Controller
{
    public function index()
    {
        return CourseResource::collection(GetInstructorCoursesAction::run());
    }

    public function store(StoreCourseData $data)
    {
        $course = StoreCourseAction::run($data);

        return CourseResource::make($course);
    }

    public function show(Course $course)
    {
        return CourseResource::make($course);
    }
    
    public function getBasicInfo(Course $course)
    {
        $this->authorize('update', $course);

        return response()->json([
            'course' => CourseResource::make($course->load('category')),
            'categories' => CategoryResource::collection(GetAllCategoriesAction::run()),
            'levels' => CourseLevel::getArray(),
        ]);
    }
    
    public function updateBasicInfo(UpdateCourseData $data, Course $course)
    {
        $this->authorize('update', $course);

        $course = UpdateCourseAction::run($data, $course);

        return CourseResource::make($course->load('category'));
    }

    public function curriculum(Course $course)
    {
        $this->authorize('update', $course);

        return GetInstructorCourseCurriculumAction::run($course);
    }

    public function cover(UploadCourseImageData $data, Course $course)
    {
        $this->authorize('update', $course);

        $course = UploadCourseImageAction::run($data, $course);

        return CourseResource::make($course);
    }

    public function updateStatus(Course $course)
    {
        abort_unless(
            $course->canBePublished(),
            401,
            'Course not ready for status change.'
        );
        $course = UpdateCourseStatusAction::run($course);

        // send email notification to author that the course is published
        return CourseResource::make($course->fresh());
    }
}
