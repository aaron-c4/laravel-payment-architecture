<?php

namespace App\Services;

use App\Interfaces\PaymentGateway;

class PaypalService implements PaymentGateway
{
    public function charge(float $amount): array
    {
        // Simulamos latencia de red
        sleep(2);

        return [
            'provider' => 'paypal',
            'amount' => $amount,
            'status' => 'success',
            'transaction_id' => 'PAY-'.uniqid(),
        ];
    }
}
