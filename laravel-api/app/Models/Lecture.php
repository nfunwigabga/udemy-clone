<?php

namespace App\Models;

use App\Enums\LectureType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Lecture extends BaseModel implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'duration_minutes',
        'course_id',
        'section_id',
        'sort_order',
        'title',
        'type',
        'body',
    ];

    protected $casts = [
        'type' => LectureType::class,
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function video()
    {
        return $this->hasOne(Video::class);
    }

    public function scopeHasContent(Builder $builder)
    {
        return $builder->where(function ($q) {
            $q->where('type', (LectureType::TEXT)->value)
                ->whereNotNull('body');
        })->orWhere(function ($q) {
            $q->where('type', (LectureType::VIDEO)->value)
                ->whereHas('video');
        });
    }

    public function getNext()
    {
        return static::where('course_id', $this->course_id)
            ->where('sort_order', '>', $this->sort_order)
            ->orderBy('sort_order', 'asc')
            ->first(['hashid', 'title']);
    }

    public function getPrevious()
    {
        return static::where('course_id', $this->course_id)
            ->where('sort_order', '<', $this->sort_order)
            ->orderBy('sort_order', 'desc')
            ->first(['hashid', 'title']);
    }

    public function hasContent()
    {
        if ($this->type == LectureType::TEXT && ! empty($this->body)) {
            return true;
        }
        if ($this->type == LectureType::VIDEO && ! empty($this->video)) {
            return true;
        }

        return false;
    }

    public function getDurationHMSAttribute()
    {
        if ($this->duration_minutes) {
            return convert_minutes_to_duration($this->duration_minutes);
        }

        return '00:00:00';
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('attachments')
            ->useDisk('attachments');
    }
}
