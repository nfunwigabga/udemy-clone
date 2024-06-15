<?php

namespace App\Jobs;

use App\Enums\VideoStatus;
use App\Events\VideoUploadProgress;
use App\Models\Video;
use FFMpeg\Format\Video\X264;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Throwable;

class ProcessVideoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // how many times laravel should try to process the job
    public $tries = 1;

    // how much time to wait before retrying (in seconds)
    public $backoff = 10; // can also be [2,4,5,...]

    // maximum number of exceptions allowed. will override retry count
    public $maxExceptions = 3;

    public $timeout = 0;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public Video|Model $video)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->video->update([
            'status' => VideoStatus::PROCESSING,
        ]);

        $extension = config('site.extensions.stream');
        $video = FFMpeg::fromDisk($this->video->temp_disk)->open($this->video->temp_path);
        $duration = $video->getDurationInSeconds();
        $this->video->lecture->update([
            'duration_minutes' => $duration / 60,
        ]);
        // create different bitrates for low, medium and high bandwidth
        $midBitrate = (new X264('aac'))->setKiloBitrate(500);
        $highBitrate = (new X264('aac'))->setKiloBitrate(1000);
        $stream_name = uniqid(true).$extension;

        FFMpeg::fromDisk($this->video->temp_disk)
            ->open($this->video->temp_path)
            ->exportForHLS()
        ->withRotatingEncryptionKey(function ($filename, $contents) {
            Storage::disk('digitalocean')->put("secrets/{$filename}", $contents);
        })
            ->onProgress(function ($progress) {
                $this->video->update([
                    'processing_percent' => $progress,
                ]);
                sleep(1);
                broadcast(new VideoUploadProgress($this->video->refresh()->lecture));
            })
            ->addFormat($midBitrate, fn ($media) => $media->scale(720, 480))
            ->addFormat($highBitrate, fn ($media) => $media->scale(1280, 720))
            ->toDisk($this->video->stream_disk)
            ->save("{$this->video->id}/{$stream_name}");

        $this->video->update([
            'duration_seconds' => $duration,
            'stream_name' => $stream_name,
            'status' => VideoStatus::SUCCESSFUL,
            'processing_ended_at' => now(),
            'failure_details' => null,
        ]);
        broadcast(new VideoUploadProgress($this->video->refresh()->lecture));
        FFMpeg::cleanupTemporaryFiles();
        // clean uploaded tmp file
        if (Storage::disk($this->video->temp_disk)->exists($this->video->temp_path)) {
            Storage::disk($this->video->temp_disk)->delete($this->video->temp_path);
        }
    }

    // code to run if the job fails
    public function failed(Throwable $exception = null)
    {
        $this->video->update([
            'status' => VideoStatus::FAILED,
            'processing_ended_at' => now(),
            'failure_details' => $exception->getMessage(),
        ]);

        $this->video->lecture->update([
            'duration_minutes' => 0,
        ]);
    }
}
