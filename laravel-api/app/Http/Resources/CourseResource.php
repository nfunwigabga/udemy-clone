<?php

namespace App\Http\Resources;

use App\Enums\CourseTarget;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->hashid,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'slug' => $this->slug,
            'published' => $this->isPublished(),
            'canBePublished' => $this->canBePublished(),
            'status' => $this->isPublished() ? 'Published' : 'Draft',
            'level' => $this->level,
            'price' => $this->price,
            'price_formatted' => $this->price_formatted,
            'description' => $this->description,
            'cover' => $this->cover_image_url,
            'thumbnail' => $this->thumbnail_url,
            'stats' => $this->getStats(),
            $this->mergeWhen($this->relationLoaded('author'), [
                'author' => [
                    'id' => $this->author->hashid,
                    'name' => $this->author->name,
                    'avatar' => $this->author->avatar,
                ],
            ]),
            $this->mergeWhen($this->relationLoaded('category'), [
                'category' => [
                    'id' => $this->category->hashid,
                    'name' => $this->category->name,
                ],
                'subcategory' => [
                    'id' => $this->subcategory->hashid,
                    'name' => $this->subcategory->name,
                ],
            ]),
            'sections' => SectionResource::collection($this->whenLoaded('sections')),
            $this->mergeWhen($this->relationLoaded('targets'), [
                'what_to_learn' => TargetResource::collection($this->getTargets(CourseTarget::WHAT_TO_LEARN->value)),
                'requirement' => TargetResource::collection($this->getTargets(CourseTarget::REQUIREMENT->value)),
                'target_students' => TargetResource::collection($this->getTargets(CourseTarget::TARGET_STUDENT->value)),
            ]),
        ];
    }
}
