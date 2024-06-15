<?php

namespace App\Enums;

enum CourseLevel: string
{
    case ALL = 'all';
    case BEGINNER = 'beginner';
    case INTERMEDIATE = 'intermediate';
    case ADVANCED = 'advanced';

    // App\Enums\CourseLevel::tryFrom("alla") ?? "xx";

    public static function getValues(): array
    {
        return array_map(fn ($level) => $level->value, self::cases());
    }

    public static function getArray(): array
    {
        return array_map(fn ($level) => [
            'id' => $level->value,
            'name' => ucfirst($level->value),
        ], self::cases());
    }
}
