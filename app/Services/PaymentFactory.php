<?php

namespace App\Services;

use InvalidArgumentException;

class PaymentFactory
{
    /**
     * Create a new payment gateway instance.
     */
    public function make(string $provider): PaymentGatewayInterface
    {
        return match (strtolower($provider)) {
            'paypal' => app(\App\Services\PaypalService::class),
            'stripe' => app(\App\Services\StripeService::class),
            default  => throw new InvalidArgumentException("Invalid payment provider: {$provider}"),
        };
    }
}