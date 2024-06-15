<?php

namespace App\Data\Section;

use Spatie\LaravelData\Data;

class CourseSectionData extends Data
{
    public string $title;

    public static function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:100'],
        ];
    }
}
