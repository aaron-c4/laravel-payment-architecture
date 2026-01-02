<?php

namespace App\Providers;

use App\Interfaces\PaymentGateway;
use App\Services\PaypalService;
use App\Services\StripeService;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // AQUÍ ESTÁ TU TEORÍA APLICADA
        $this->app->bind(PaymentGateway::class, function ($app) {

            // Leemos la config (simulada desde .env)
            $provider = env('PAYMENT_DEFAULT', 'paypal');

            if ($provider === 'stripe') {
                return new StripeService;
            }

            return new PaypalService;
        });
    }

    public function boot(): void
    {
        //
    }
}
