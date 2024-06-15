<?php

namespace App\Actions\Payment;

use App\Enums\TransactionType;
use App\Models\Course;
use App\Models\Payment;
use App\Models\Period;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

class StorePaymentAction
{
    public static function run(Authenticatable|User $payer, Course $course, string $payment_id)
    {
        $author_percent = config('site.author_percent');
        $period = Period::current()->first();

        $payment = Payment::create([
            'payer_id' => $payer->id,
            'course_id' => $course->id,
            'coupon_id' => null,
            'period_id' => $period->id,
            'gateway_payment_id' => $payment_id,
            'amount' => $course->price,
            'author_earning' => $course->price * $author_percent,
            'description' => "Purchase of {$course->title}",
            'refund_deadline' => now('UTC')->addDays(30),

        ]);

        $payment->transaction()->create([
            'user_id' => $course->author->id,
            'type' => TransactionType::CREDIT,
            'description' => $payment->description,
            'amount' => $payment->author_earning,
        ]);
    }
}
