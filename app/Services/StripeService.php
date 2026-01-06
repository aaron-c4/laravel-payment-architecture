<?php

namespace App\Services;

use App\Services\PaymentGatewayInterface;

class StripeService implements PaymentGatewayInterface
{
    public function charge(float $amount): array
    {
        return [
            'provider' => 'stripe',
            'amount' => $amount,
            'status' => 'success',
            'transaction_id' => 'STR-' . uniqid(),
        ];
    }
}