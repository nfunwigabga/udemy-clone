<?php

namespace App\Http\Controllers\Instructor;

use App\Actions\Lecture\ReorderCourseLecturesAction;
use App\Actions\Section\DeleteSectionAction;
use App\Actions\Section\ReorderCourseSectionsAction;
use App\Actions\Section\StoreSectionAction;
use App\Actions\Section\UpdateSectionAction;
use App\Actions\Section\UpdateSectionSortOrderAction;
use App\Data\Section\CourseSectionData;
use App\Http\Controllers\Controller;
use App\Http\Resources\SectionResource;
use App\Models\Course;
use App\Models\Section;
use Illuminate\Http\Request;

class InstructorSectionController extends Controller
{
    public function store(CourseSectionData $data, Course $course)
    {
        $section = StoreSectionAction::run($data, $course);

        return SectionResource::make($section->load('lectures'));
    }

    public function update(CourseSectionData $data, Course $course, Section $section)
    {
        $section = UpdateSectionAction::run($data, $section);

        return SectionResource::make($section->load('lectures'));
    }

    public function handleDragged(Request $request, Course $course)
    {
        UpdateSectionSortOrderAction::run($course, $request->all());

        ReorderCourseLecturesAction::run($course);

        return SectionResource::collection($course->sections->load('lectures'));
    }

    public function destroy(Course $course, Section $section)
    {
        DeleteSectionAction::run($section);

        ReorderCourseSectionsAction::run($course);

        return response()->json(null, 200);
    }
}
