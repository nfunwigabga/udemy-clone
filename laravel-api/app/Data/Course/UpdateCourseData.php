<?php

namespace App\Data\Course;

use App\Enums\CourseLevel;
use Illuminate\Validation\Rule;
use Spatie\LaravelData\Data;

class UpdateCourseData extends Data
{
    public string $title;

    public string $subtitle;

    public string $description;

    public string $level;

    public string $category;

    public string $subcategory;

    public static function rules(): array
    {
        return [
            //            'title' => [
            //                'required',
            //                Rule::unique('courses')
            //                    ->ignore(request('course')->id)
            //            ],
            'title' => ['required'],
            'subtitle' => ['required'],
            'category' => ['required', 'exists:categories,hashid'],
            'subcategory' => ['required', 'exists:categories,hashid'],
            'description' => ['required', 'string'],
            'level' => ['required', 'string', Rule::in(CourseLevel::getValues())],
        ];
    }
}
