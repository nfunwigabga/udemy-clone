<?php

namespace App\Actions\Target;

use App\Models\Target;

class DestroyCourseTargetAction
{
    public static function run(Target $target)
    {
        $target->delete();
    }
}
