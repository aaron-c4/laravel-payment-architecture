<?php

namespace App\Services;


use App\Services\PaymentGatewayInterface;


class PaypalService implements PaymentGatewayInterface
{
    public function charge(float $amount): array
    {
        return [
            'provider' => 'paypal',
            'amount' => $amount,
            'status' => 'success',
            'transaction_id' => 'PAY-' . uniqid(),
        ];
    }
}