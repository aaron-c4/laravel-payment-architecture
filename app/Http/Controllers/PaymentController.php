<?php

namespace App\Http\Controllers;

use App\Interfaces\PaymentGateway;
use App\Models\Transaction;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // Inyección de Dependencias
    public function __construct(
        protected PaymentGateway $gateway
    ) {}

    public function store(Request $request)
    {
        // 1. Buscamos al usuario "falso" (Simulamos que está logueado)
        $user = \App\Models\User::find(1);

        // Pequeña validación por si olvidasto el db:seed
        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado. Ejecuta: php artisan db:seed'], 404);
        }

        // 2. Procesamos el cobro con el Servicio (Esto no cambia)
        $result = $this->gateway->charge($request->input('amount'));

        // 3. LA MAGIA DE ELOQUENT:
        // En lugar de usar Transaction::create y pasarle manualmente el ID...
        // Usamos la relación "$user->transactions()".
        //asigna automáticamente el 'user_id' por nosotros.
    
        $transaction = $user->transactions()->create([
            'provider'    => $result['provider'],
            'amount'      => $result['amount'],
            'status'      => $result['status'],
            'external_id' => $result['transaction_id']
            // ¡sin user_id aquí!
        ]);

        return response()->json([
            'message' => 'Pago procesado y asociado al usuario',
            'data' => $transaction
        ]);
    }
}