<?php

namespace App\Actions\Lecture;

use App\Enums\LectureType;
use App\Jobs\ProcessVideoJob;
use App\Models\Lecture;
use Illuminate\Http\UploadedFile;

class UploadChunkedVideoAction
{
    public static function run(Lecture $lecture, UploadedFile $file)
    {
        return tap($lecture->video, function ($previous) use ($file, $lecture) {
            $temp_disk = config('site.disks.videos.temp');
            $stream_disk = config('site.disks.videos.stream');
            $mime_type = config('site.extensions.stream_mimetype');

            // move video to temporary directory. filename is automatically generated
            $path = $file->store($lecture->id, $temp_disk);
            $name = $file->getClientOriginalName();

            $video = $lecture->video()->create([
                'original_file_name' => $name,
                'temp_path' => $path,
                'temp_disk' => $temp_disk,
                'stream_disk' => $stream_disk,
                'mime_type' => $mime_type,
                'processing_percent' => 0,
                'uploaded_at' => now(),
            ]);

            $previous?->delete();

            $lecture->update([
                'type' => LectureType::VIDEO,
                'body' => null,
            ]);

            dispatch(new ProcessVideoJob($video));

            return [
                'path' => $path,
                'name' => $name,
                'mime_type' => $mime_type,
            ];
        });
    }
}
