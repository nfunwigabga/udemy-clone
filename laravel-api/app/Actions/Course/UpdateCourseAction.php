<?php

namespace App\Actions\Course;

use App\Data\Course\UpdateCourseData;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Support\Str;

class UpdateCourseAction
{
    public static function run(UpdateCourseData $data, Course $course)
    {
        return tap($course)->update([
            'title' => $data->title,
            'slug' => Str::slug($data->title),
            'subtitle' => $data->subtitle,
            'description' => $data->description,
            'level' => $data->level,
            'category_id' => Category::getId($data->category),
            'subcategory_id' => Category::getId($data->subcategory),
        ]);
    }
}
