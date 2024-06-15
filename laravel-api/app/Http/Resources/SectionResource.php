<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->hashid,
            'title' => $this->title,
            'course' => $this->course->hashid,
            'can_trash' => ! $this->lectures->count(),
            'sort_order' => $this->sort_order,
            'lectures' => LectureResource::collection($this->whenLoaded('lectures')),
        ];
    }
}
