<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: "1.0.0",
    description: "API de Pagos con Autenticación Sanctum",
    title: "Payment API",
    contact: new OA\Contact(email: "admin@example.com")
)]
#[OA\Server(
    url: "http://127.0.0.1:8000",
    description: "Servidor Local"
)]
#[OA\SecurityScheme(
    securityScheme: 'bearerAuth',
    type: 'http',
    scheme: 'bearer',
    bearerFormat: 'JWT'
)]
class Controller
{
    // 
}