<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentRequest;
use App\Services\PaymentGatewayInterface;
use Illuminate\Support\Facades\Log;
use Exception;
use OpenApi\Attributes as OA; // Importante

class PaymentController extends Controller
{
    protected $gateway;

    public function __construct(PaymentGatewayInterface $gateway)
    {
        $this->gateway = $gateway;
    }

    #[OA\Post(
        path: '/api/pay',
        summary: 'Procesar un pago',
        tags: ['Payments'],
        security: [['bearerAuth' => []]], // Requiere candado
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'amount', type: 'number', format: 'float', example: 150.00),
                    new OA\Property(property: 'provider', type: 'string', example: 'stripe'),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Pago procesado',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'Payment processed successfully'),
                        new OA\Property(property: 'data', type: 'object')
                    ]
                )
            ),
            new OA\Response(response: 401, description: 'No autenticado')
        ]
    )]
    public function store(StorePaymentRequest $request)
    {
        try {
            $user = $request->user();
            $validated = $request->validated();
            
            $result = $this->gateway->charge($validated['amount']);

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
            Log::error('Payment processing failed', [
                'error' => $e->getMessage(),
                'user_id' => $request->user() ? $request->user()->id : 'guest',
            ]);

            return response()->json([
                'message' => 'Error processing payment',
                'error_code' => 'PAYMENT_ERROR'
            ], 500);
        }
    }
}