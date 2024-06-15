<?php

namespace App\Models;

use App\Enums\CourseLevel;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Course extends BaseModel implements HasMedia
{
    use InteractsWithMedia;
    use Sluggable;

    protected $fillable = [
        'user_id',
        'category_id',
        'subcategory_id',
        'title',
        'subtitle',
        'slug',
        'description',
        'level',
        'price',
        'published_at',
    ];

    protected $casts = [
        'level' => CourseLevel::class,
        'published_at' => 'datetime',
        'price' => 'float',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'subcategory_id');
    }

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class)->orderBy('sort_order');
    }

    public function lectures(): HasMany
    {
        return $this->hasMany(Lecture::class);
    }

    public function targets(): HasMany
    {
        return $this->hasMany(Target::class)->orderBy('sort_order', 'asc');
    }

    public function getTargets(string $type)
    {
        return $this->targets()->type($type)->get();
    }

    public function coupons(): HasMany
    {
        return $this->hasMany(Coupon::class);
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'enrollments', 'course_id', 'user_id')
        ->withTimestamps();
    }

    public function getPriceFormattedAttribute()
    {
        if ($this->price > 0) {
            return money($this->price, 'USD', true)->format();
        }

        return 'Free';
    }

    public function firstLecture(): HasOne
    {
        return $this->lectures()->one()->ofMany('sort_order', 'min');
    }

    public function scopePublished(Builder $builder)
    {
        $builder->whereNotNull('published_at');
    }

    public function canBePublished()
    {
        if ($this->lectures()->exists() && $this->image()->exists()) {
            return true;
        }

        return false;
    }

    public function isPublished(): bool
    {
        return ! is_null($this->published_at);
    }

    public function image(): MorphOne
    {
        return $this->morphOne(Media::class, 'model')
            ->where('collection_name', 'cover');
    }

    // register thumbnail conversion
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover')
            ->useDisk('covers')
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('thumb')
                    ->width(300)
                    ->height(169);
            });
    }

    public function getCoverImageUrlAttribute()
    {
        if (! $this->image) {
            return Storage::disk('media')->url('covers/default.png');
        }

        return $this->getFirstMediaUrl('cover', 'cover');
    }

    public function getThumbnailUrlAttribute()
    {
        if (! $this->image) {
            return $this->cover_image_url;
        }

        return $this->getFirstMedia('cover')->getUrl('thumb');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }

    public function getDurationMinutes()
    {
        return $this->lectures->sum('duration_minutes');
    }

    public function getDurationHours()
    {
        $minutes = $this->getDurationMinutes();

        return round($minutes / 60, 1);
    }

    public function getStats()
    {
        return [
            'duration' => convert_minutes_to_duration($this->getDurationMinutes()),
            'total_hrs' => $this->getDurationHours(),
        ];
    }
}
