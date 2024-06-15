<?php

namespace App\Services;

use Stripe\StripeClient;

class StripeService
{
    private $stripe;

    public function __construct()
    {
        $this->stripe = new StripeClient(config('site.stripe.secret'));
    }

    public function createPaymentIntent($amount)
    {
        $intent = $this->stripe->paymentIntents->create([
            'amount' => $amount,
            'currency' => config('site.currency'),
            'automatic_payment_methods' => ['enabled' => true],
        ]);

        return $intent->client_secret;
    }
}
