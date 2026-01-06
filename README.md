# 🚀 MockPay API - Arquitectura Modular en Laravel

![PHP Version](https://img.shields.io/badge/php-8.4-777BB4.svg)
![Laravel Version](https://img.shields.io/badge/laravel-12.x-FF2D20.svg)
![Tests](https://img.shields.io/badge/tests-passing-brightgreen.svg)
![Swagger](https://img.shields.io/badge/docs-swagger-85EA2D.svg)

Este proyecto es una implementación de prueba de concepto (PoC) diseñada para demostrar patrones de arquitectura avanzados, seguridad y desacoplamiento en **Laravel 12**.

## 🧠 Conceptos Implementados

* **Strategy Pattern:** Implementación polimórfica de pasarelas de pago (`Paypal`, `Stripe`) intercambiables en tiempo de ejecución sin modificar el código base (Open/Closed Principle).
* **Documentación Viva (OpenAPI):** Generación automática de documentación interactiva con Swagger UI.
* **Seguridad con Sanctum:** Autenticación robusta basada en Tokens (Bearer Auth).
* **Service Container:** Inyección de dependencias y resolución automática de interfaces.
* **Testing Automatizado:** Pruebas unitarias y de funcionalidad (Feature Tests) escritas con **Pest PHP**.

## 🏗 Arquitectura del Proyecto

El núcleo del patrón Strategy reside en la carpeta `Services`, separando los contratos de las implementaciones:

```text
app/
├── Http/
│   └── Controllers/
│       └── PaymentController.php      # Contexto (Inyecta la Interfaz)
├── Providers/
│   └── AppServiceProvider.php         # Binding (Conecta Interfaz -> Stripe/PayPal)
└── Services/
    ├── PaymentGatewayInterface.php    # El Contrato (Interface)
    ├── StripeService.php              # Estrategia Concreta 1
    └── PaypalService.php              # Estrategia Concreta 2

## 🛠 Stack Tecnológico

* **Lenguaje:** PHP 8.4
* **Framework:** Laravel 12
* **Base de Datos:** MySQL
* **Testing:** Pest PHP
* **Docs:** L5-Swagger (OpenAPI 3.0)

## ⚡️ Instalación y Configuración

Sigue estos pasos para desplegar el proyecto localmente:

1.  **Clonar el repositorio**
    ```bash
    git clone https://github.com/aaron-c4/laravel-payment-architecture.git
    cd laravel-payment-architecture
    ```

2.  **Instalar dependencias**
    ```bash
    composer install
    ```

3.  **Configurar entorno**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4.  **Base de Datos**
    Asegúrate de tener MySQL corriendo y crea una base de datos vacía (ej. `mockpay_db`). Luego configura el `.env`:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=mockpay_db
    DB_USERNAME=root
    DB_PASSWORD=
    ```

5.  **Migrar y Sembrar datos**
    ```bash
    php artisan migrate --seed
    ```

6.  **Levantar servidor**
    ```bash
    php artisan serve
    ```

## 📘 Documentación API (Swagger)

Una vez levantado el servidor, puedes probar todos los endpoints visualmente (incluyendo Login y Pagos) en:

👉 **[http://127.0.0.1:8000/api/documentation](http://127.0.0.1:8000/api/documentation)**

| Método | Endpoint | Descripción | Auth |
| :--- | :--- | :--- | :---: |
| `POST` | `/api/login` | Obtener Token de Acceso | ❌ |
| `POST` | `/api/pay` | Procesar un Pago (Strategy) | ✅ |

## 🧪 Ejecutar Tests

El proyecto cuenta con una suite de pruebas automatizadas para garantizar la estabilidad del sistema de pagos.

```bash
./vendor/bin/pest

Salida esperada:

✓ authenticated user can process a payment successfully 
✓ guest user cannot process payments