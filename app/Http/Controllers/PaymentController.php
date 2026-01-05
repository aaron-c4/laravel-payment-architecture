<?php

namespace App\Http\Controllers;

use App\Interfaces\PaymentGateway;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Requests\StorePaymentRequest;

class PaymentController extends Controller
{
    // Inyección de Dependencias
    public function __construct(
        protected PaymentGateway $gateway
    ) {}

    /**
     * Process a new payment transaction.
     */
    public function store(StorePaymentRequest $request)
    {
        // TODO: Retrieve the authenticated user dynamically via Auth::user()
        $user = \App\Models\User::find(1);

        // Retrieve only the validated input data
        $validated = $request->validated();

        // Process payment through the injected gateway strategy
        $result = $this->gateway->charge($validated['amount']);

        // Persist the transaction record
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
    }
}
