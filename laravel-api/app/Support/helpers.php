<?php

declare(strict_types=1);

if (! function_exists('convert_minutes_to_duration')) {
    function convert_minutes_to_duration($total_minutes, $format = '%02d:%02d:%02d')
    {
        if ($total_minutes < 0.0 || ! $total_minutes) {
            return '00:00:00';
        }

        $hours = floor($total_minutes / 60);
        $minutes = ($total_minutes % 60);
        $seconds = ($total_minutes * 60) % 60;

        return sprintf($format, $hours, $minutes, $seconds);
    }
}

if (! function_exists('convert_hours_to_duration')) {
    function convert_hours_to_duration($total_hours, $format = '%02d:%02d:%02d')
    {
        $total_minutes = $total_hours * 60;
        if ($total_minutes < 0.0 || ! $total_minutes) {
            return '00:00:00';
        }

        $hours = floor($total_minutes / 60);
        $minutes = ($total_minutes % 60);
        $seconds = ($total_minutes * 60) % 60;

        return sprintf($format, $hours, $minutes, $seconds);
    }
}
