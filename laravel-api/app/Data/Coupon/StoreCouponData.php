<?php

namespace App\Data\Coupon;

use Illuminate\Validation\Rule;
use Spatie\LaravelData\Data;

class StoreCouponData extends Data
{
    public string $code;

    public float $percent;

    public int $quantity;

    public ?string $expires_at;

    public static function rules(): array
    {
        return [
            'code' => [
                'required', 'string', 'alpha_dash', 'max:100',
                Rule::unique('coupons')
                    ->where(fn ($q) => $q->where('course_id', request('course')->id)),
            ],
            'percent' => ['required', 'numeric', 'max:100', 'min:0'],
            'quantity' => ['required', 'numeric', 'min:1'],
            'expires_at' => ['nullable', 'date', 'after_or_equal:tomorrow'],
        ];
    }
}
