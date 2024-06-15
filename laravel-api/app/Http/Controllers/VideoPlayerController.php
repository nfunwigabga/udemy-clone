<?php

namespace App\Http\Controllers;

use App\Actions\Video\GetVideoFromStreamNameAction;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class VideoPlayerController extends Controller
{
    public function playlist(string $playlist = null)
    {
        $disk = config('site.disks.videos.stream');
        $extension = Str::of($playlist)->afterLast('.');
        $base = Str::of($playlist)->before('_');
        $filename = Str::of($base)->finish(".{$extension}");
        $video = GetVideoFromStreamNameAction::run($filename);

        return FFMpeg::dynamicHLSPlaylist()
            ->fromDisk($disk)
            ->open("{$video->id}/{$playlist}")
            ->setKeyUrlResolver(function ($key) {
                return route('video.key', ['key' => $key]);
            })
            ->setMediaUrlResolver(function ($mediaFilename) use ($disk, $video) {
                return Storage::disk($disk)->url("{$video->id}/{$mediaFilename}");
            })
            ->setPlaylistUrlResolver(function ($playlistFilename) {
                return route('video.playlist', ['playlist' => $playlistFilename]);
            });
    }

    public function secrets(string $key)
    {
        $disk = config('site.disks.videos.stream');

        return Storage::disk($disk)->download("/secrets/{$key}");
    }
}
