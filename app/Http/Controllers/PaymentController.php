<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Services\PaymentFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Handle the payment process.
     * * Note: Validation is automatically handled by PaymentRequest before reaching here.
     */
    public function pay(PaymentRequest $request, PaymentFactory $factory): JsonResponse
    {
        // 1. Log the attempt
        Log::info('Starting payment process', [
            'provider' => $request->provider, 
            'amount' => $request->amount
        ]);

        try {
            // 2. Get the correct service from the Factory
            $gateway = $factory->make($request->provider);

            // 3. Execute the charge
            $result = $gateway->charge($request->amount);

            return response()->json([
                'status' => 'success',
                'message' => 'Payment processed successfully',
                'data' => $result,
            ]);

        } catch (\Exception $e) {
            Log::error('Payment failed', ['error' => $e->getMessage()]);

            return response()->json([
                'status' => 'error',
                'message' => 'Payment processing failed.',
            ], 500);
        }
    }
}