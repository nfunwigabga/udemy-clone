<?php

namespace App\Data\Lecture;

use Spatie\LaravelData\Data;

class LectureArticleContentData extends Data
{
    public string $body;

    public static function rules(): array
    {
        return [
            'body' => ['required', 'string'],
        ];
    }
}
