<?php

namespace App\Actions\Target;

use App\Models\Target;

class UpdateCourseTargetsAction
{
    public static function run(array $data)
    {
        foreach ($data as $item) {
            $target = Target::find(Target::getId($item['id']));
            $target->sort_order = $item['sort_order'];
            $target->save();
        }
    }
}
