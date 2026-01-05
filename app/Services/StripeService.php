<?php

namespace App\Services;

use App\Interfaces\PaymentGateway;

class StripeService implements PaymentGateway
{
    public function charge(float $amount): array
    {

        // Simulamos un comportamiento distinto
        return [
            'provider' => 'stripe',
            'amount' => $amount,
            'status' => 'success',
            'transaction_id' => 'STR-'.uniqid(),
        ];
    }
}
