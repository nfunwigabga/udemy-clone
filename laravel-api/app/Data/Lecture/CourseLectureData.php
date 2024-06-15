<?php

namespace App\Data\Lecture;

use Spatie\LaravelData\Data;

class CourseLectureData extends Data
{
    public string $title;

    public static function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:100'],
        ];
    }
}
