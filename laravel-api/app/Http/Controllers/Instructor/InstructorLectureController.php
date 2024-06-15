<?php

namespace App\Http\Controllers\Instructor;

use App\Actions\Lecture\DeleteLectureAction;
use App\Actions\Lecture\ReorderCourseLecturesAction;
use App\Actions\Lecture\StoreLectureAction;
use App\Actions\Lecture\UpdateLectureAction;
use App\Actions\Lecture\UpdateLectureSortOrderAction;
use App\Data\Lecture\CourseLectureData;
use App\Http\Controllers\Controller;
use App\Http\Resources\LectureResource;
use App\Http\Resources\SectionResource;
use App\Models\Course;
use App\Models\Lecture;
use App\Models\Section;

class InstructorLectureController extends Controller
{
    public function store(CourseLectureData $data, Course $course, Section $section)
    {
        $this->authorize('update', $course);
        $lecture = StoreLectureAction::run($data, $course, $section);
        ReorderCourseLecturesAction::run($course);

        return LectureResource::make($lecture->fresh());
    }

    public function update(CourseLectureData $data, Course $course, Lecture $lecture)
    {
        $this->authorize('update', $course);

        $lecture = UpdateLectureAction::run($data, $lecture);

        return LectureResource::make($lecture);
    }

    public function handleDragged(Course $course)
    {
        $this->authorize('update', $course);
        UpdateLectureSortOrderAction::run($course, request()->all());

        return SectionResource::collection($course->sections->load('lectures'));
    }

    public function destroy(Course $course, Lecture $lecture)
    {
        $this->authorize('update', $course);
        DeleteLectureAction::run($lecture);
        ReorderCourseLecturesAction::run($lecture->course);

        return SectionResource::collection($course->sections->load('lectures'));
    }
}
