<?php

namespace App\Data\Lecture;

use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Data;

class LectureVideoContentData extends Data
{
    public UploadedFile $file;

    public static function rules(): array
    {
        return [
            'file' => ['required', 'file', 'mimes:mp4'],
        ];
    }
}
