<?php

namespace App\Models;

use App\Enums\TransactionType;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Transaction extends BaseModel
{
    protected $fillable = [
        'hashid',
        'user_id',
        'type',
        'description',
        'long_description',
        'amount',
    ];

    protected $casts = [
        'amount' => 'float',
        'type' => TransactionType::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactable(): MorphTo
    {
        return $this->morphTo();
    }
}
