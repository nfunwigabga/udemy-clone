<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->hashid,
            'name' => $this->name,
            'slug' => $this->slug,
            $this->mergeWhen(! $this->parent_id, [
                'children' => static::collection($this->whenLoaded('children')),
            ]),
        ];
    }
}
