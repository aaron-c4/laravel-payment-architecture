<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentRequest;
use App\Interfaces\PaymentGateway;
use Illuminate\Support\Facades\Log; // <--- Importante: Herramienta de Logs
use Exception;

class PaymentController extends Controller
{
    protected $gateway;

    /**
     * Dependency Injection via Service Container.
     */
    public function __construct(PaymentGateway $gateway)
    {
        $this->gateway = $gateway;
    }

    /**
     * Process a new payment transaction with error handling.
     */
    public function store(StorePaymentRequest $request)
    {
        try {
            // TODO: Retrieve the authenticated user dynamically via Auth::user()
            $user = \App\Models\User::find(1);

            // Retrieve validated data
            $validated = $request->validated();

            // Attempt to charge the wallet
            $result = $this->gateway->charge($validated['amount']);

            // Persist transaction
            $transaction = $user->transactions()->create([
                'provider'    => $result['provider'],
                'amount'      => $result['amount'],
                'status'      => $result['status'],
                'external_id' => $result['transaction_id']
            ]);

            return response()->json([
                'message' => 'Payment processed successfully',
                'data' => $transaction
            ]);

        } catch (Exception $e) {
            // 1. Log the technical error for developers (Internal)
            Log::error('Payment processing failed', [
                'error' => $e->getMessage(),
                'user_id' => 1, // Static for now
                'trace' => $e->getTraceAsString()
            ]);

            // 2. Return a generic error message to the user (Public)
            return response()->json([
                'message' => 'An error occurred while processing your payment. Please try again later.',
                'error_code' => 'PAYMENT_GATEWAY_ERROR' // Optional custom code
            ], 500);
        }
    }
}