<?php

use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\Middleware\ThrottleRequests;

uses(RefreshDatabase::class); // Penting untuk reset database setiap test

it('cannot create product without authentication', function () {
    $response = $this->postJson('/api/products', []);
    $response->assertStatus(401);
});

it('validates required fields when creating product', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->withoutMiddleware(ThrottleRequests::class)
        ->postJson('/api/products', []);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['name', 'sku', 'quantity', 'price']);
});

it('creates a product successfully', function () {
    $user = User::factory()->create();

    $payload = [
        'name' => 'Laptop Asus',
        'sku' => 'SKU123',
        'quantity' => 10,
        'price' => 15000000,
    ];

    $response = $this->actingAs($user)
        ->withoutMiddleware(ThrottleRequests::class)
        ->postJson('/api/products', $payload);

    $response->assertStatus(200)
        ->assertJson([
            'status' => true,
            'message' => 'Product created successfully'
        ]);

    $this->assertDatabaseHas('products', [
        'name' => 'Laptop Asus',
        'sku' => 'SKU123',
    ]);
});