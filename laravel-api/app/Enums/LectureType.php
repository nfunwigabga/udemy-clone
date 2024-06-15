<?php

namespace App\Enums;

enum LectureType: string
{
    case VIDEO = 'video';
    case TEXT = 'text';
    case QUIZ = 'quiz';
}
