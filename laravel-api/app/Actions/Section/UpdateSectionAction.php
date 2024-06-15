<?php

namespace App\Actions\Section;

use App\Data\Section\CourseSectionData;
use App\Models\Section;

class UpdateSectionAction
{
    public static function run(CourseSectionData $data, Section $section)
    {
        return tap($section)->update([
            'title' => $data->title,
        ]);
    }
}
