<?php

namespace App\Actions\Section;

use App\Models\Section;

class DeleteSectionAction
{
    public static function run(Section $section)
    {
        if ($section->lectures->count()) {
            return;
        }

        $section->delete();
    }
}
