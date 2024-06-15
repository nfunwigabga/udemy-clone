<?php

namespace App\Enums;

enum VideoStatus: string
{
    case PROCESSING = 'processing';
    case SUCCESSFUL = 'successful';
    case FAILED = 'failed';

    public function getName(): string
    {
        return match ($this) {
            self::PROCESSING => 'Processing',
            self::SUCCESSFUL => 'Successful',
            self::FAILED => 'Failed',
            default => 'Unknown status'
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::PROCESSING => 'yellow',
            self::SUCCESSFUL => 'green',
            self::FAILED => 'red-',
            default => ''
        };
    }
}
