<?php

namespace App\Enums;

enum CourseTarget: string
{
    case REQUIREMENT = 'requirement';
    case WHAT_TO_LEARN = 'what_to_learn';
    case TARGET_STUDENT = 'target_student';
}
