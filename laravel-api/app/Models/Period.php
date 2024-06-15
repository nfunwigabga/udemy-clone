<?php

namespace App\Models;

use App\Enums\PeriodStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Period extends BaseModel
{
    protected $fillable = [
        'hashid',
        'start_time',
        // 'end_time',
        'payout_date',
        'status',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        // 'end_time' => 'datetime',
        'payout_date' => 'datetime',
        'status' => PeriodStatus::class,
    ];

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function scopeCurrent(Builder $builder)
    {
        return $builder->where('start_time', '=', now('UTC')->startOfMonth());
    }

    public function isOpen()
    {
        return $this->status == PeriodStatus::OPEN;
    }

    public function isClosed()
    {
        return $this->status == PeriodStatus::CLOSED;
    }
}
