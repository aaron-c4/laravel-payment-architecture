<?php

use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\postJson;
use function Pest\Laravel\assertDatabaseHas;

// IMPORTANT: Resets the database after each test to ensure a clean state.
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('authenticated user can process a payment successfully', function () {
    // 1. Arrange: Create a factory user for the testing context
    $user = User::factory()->create();

    // 2. Act: Simulate an authenticated request to the payment endpoint.
    // actingAs($user) handles the token generation automatically.
    $response = actingAs($user)
        ->postJson('/api/pay', [
            'amount' => 150.00,
            'provider' => 'stripe'
        ]);

    // 3. Assert: Verify the response status and JSON structure
    $response->assertStatus(200)
        ->assertJson([
            'message' => 'Payment processed successfully',
            'data' => [
                'amount' => 150,
                'status' => 'success',
                'user_id' => $user->id
            ]
        ]);

    // 4. Verify Database: Ensure the transaction was actually persisted
    assertDatabaseHas('transactions', [
        'user_id' => $user->id,
        'amount' => 150,
        'provider' => 'stripe'
    ]);
});

test('guest user cannot process payments', function () {
    // Attempt to process payment without authentication
    $response = postJson('/api/pay', [
        'amount' => 100,
        'provider' => 'stripe'
    ]);

    // Expecting HTTP 401 Unauthorized response
    $response->assertStatus(401);
});