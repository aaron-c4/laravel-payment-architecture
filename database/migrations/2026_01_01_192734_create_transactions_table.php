<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {

            // Esto crea la columna user_id Y la conecta con la tabla users
            $table->foreignId('user_id')->constrained()->onDelete('cascade');


            $table->id();
            $table->string('provider');
            $table->decimal('amount', 8, 2); // 8 dígitos total, 2 decimales
            $table->string('status');
            $table->string('external_id'); // ID de Paypal/Stripe
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
