<?php

namespace App\Actions\Video;

use App\Models\Video;

class GetVideoFromStreamNameAction
{
    public static function run(string $fileName)
    {
        return Video::where('stream_name', $fileName)->first();
    }
}
