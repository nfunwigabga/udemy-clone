<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Payment extends BaseModel
{
    protected $fillable = [
        'hashid',
        'payer_id',
        'coupon_id',
        'course_id',
        'gateway_payment_id',
        'period_id',
        'transaction_id',
        'payment_method',
        'amount',
        'description',
        'author_earning',
        'status',
        'refund_deadline',
        'refunded_at',
    ];

    protected $casts = [
        'status' => PaymentStatus::class,
        'refund_deadline' => 'datetime',
        'refunded_at' => 'datetime',
        'amount' => 'float',
        'author_earning' => 'float',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'payer_id');
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    public function period(): BelongsTo
    {
        return $this->belongsTo(Period::class);
    }

    public function transaction(): MorphOne
    {
        return $this->morphOne(Transaction::class, 'transactable');
    }
}
