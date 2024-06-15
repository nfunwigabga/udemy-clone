<?php

namespace App\Data\Pricing;

use Spatie\LaravelData\Data;

class UpdateCoursePriceData extends Data
{
    public string $price;

    public static function rules(): array
    {
        return [
            'price' => ['required'],
        ];
    }
}
