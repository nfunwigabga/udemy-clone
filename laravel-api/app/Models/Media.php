<?php

namespace App\Models;

use App\Traits\WithHashId;

class Media extends \Spatie\MediaLibrary\MediaCollections\Models\Media
{
    use WithHashId;

    protected $guarded = [];

    public function getThumbnailAttribute()
    {
        if ($this->hasGeneratedConversion('thumbnail')) {
            return $this->getUrl('thumbnail');
        }

        return $this->getUrl();
    }
}
