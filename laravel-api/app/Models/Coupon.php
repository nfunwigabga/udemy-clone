<?php

/** @noinspection ALL */

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;

class Coupon extends BaseModel
{
    protected $fillable = [
        'course_id',
        'code',
        'percent',
        'quantity',
        'expires_at',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
        'expires_at' => 'date',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    protected function code(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value, // this one is unnecessary
            set: fn ($value) => strtoupper($value),
        );
    }

    public function expired()
    {
        return ! is_null($this->expires_at) && $this->expires_at < now();
    }

    public function isValid()
    {
        return $this->active && ! $this->expired();
    }
}
