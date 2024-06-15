<?php

namespace App\Events;

use App\Http\Resources\LectureResource;
use App\Models\Lecture;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VideoUploadProgress implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public Lecture $lecture)
    {
        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('lecture-'.$this->lecture->hashid),
        ];
    }

    public function broadcastAs(): string
    {
        return 'video.upload.progress';
    }

    public function broadcastWith(): array
    {
        return LectureResource::make($this->lecture)->resolve();
    }
}
