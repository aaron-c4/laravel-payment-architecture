# MockPay API - Laravel Architecture Demo 🚀

![Laravel Code Quality](https://github.com/aaron-c4/laravel-payment-architecture/actions/workflows/laravel.yml/badge.svg)

Este proyecto es una implementación de prueba de concepto (PoC) diseñada para demostrar patrones de arquitectura avanzados y desacoplamiento en **Laravel 12**.

## 🧠 Conceptos Implementados
* **Strategy Pattern:** Implementación polimórfica de pasarelas de pago (`Paypal`, `Stripe`) intercambiables en tiempo de ejecución.
* **Service Container:** Inyección de dependencias y resolución de clases basada en configuración de entorno (`.env`).
* **Clean Architecture:** Controladores "delgados" que delegan la lógica de negocio a Servicios dedicados.
* **Eloquent Relationships:** Relación `1:N` (Uno a Muchos) eficiente entre Usuarios y Transacciones.
* **Database Seeding:** Datos de prueba generados automáticamente.

## 🛠 Stack Tecnológico
* **PHP 8.4**
* **Laravel 12**
* **MySQL** (Configurado para despliegue rápido)

## ⚡️ Instalación y Configuración

1.  **Clonar el repositorio**
    ```bash
    git clone [https://github.com/aaron-c4/laravel-payment-architecture.git](https://github.com/aaron-c4/laravel-payment-architecture.git)
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

4.  **Base de Datos (MySQL)**
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