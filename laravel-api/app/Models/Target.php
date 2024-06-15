<?php

namespace App\Models;

use App\Enums\CourseTarget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Target extends BaseModel
{
    protected $fillable = [
        'course_id',
        'hashid',
        'type',
        'text',
        'sort_order',
    ];

    protected $casts = [
        'type' => CourseTarget::class,
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function scopeType(Builder $builder, string $type)
    {
        return $builder->where('type', $type);
    }
}
