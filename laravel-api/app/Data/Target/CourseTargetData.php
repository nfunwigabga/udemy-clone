<?php

namespace App\Data\Target;

use Spatie\LaravelData\Data;

class CourseTargetData extends Data
{
    public ?array $requirement;

    public ?array $what_to_learn;

    public ?array $target_student;

    public static function rules(): array
    {
        return [
            'requirement.*.text' => ['required', 'max:140'],
            'what_to_learn.*.text' => ['required', 'max:140'],
            'target_student.*.text' => ['required', 'max:140'],
        ];
    }

    // public static function messages(): array
    // {
    //     return [
    //         'requirement.items.*.text.required' => 'Entry if required',
    //         'what_to_learn.items.*.text.required' => 'Entry if required',
    //         'target_student.items.*.text.required' => 'Entry if required',
    //     ];
    // }

    public static function attributes(): array
    {
        return [
            'requirement.*.text' => 'Text',
            'what_to_learn.*.text' => 'Text',
            'target_student.*.text' => 'Text',
        ];
    }
}
