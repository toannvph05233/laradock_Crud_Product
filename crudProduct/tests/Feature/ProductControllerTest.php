<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }


    public function test_show_returns_all_products()
    {
        $product1 = Product::factory()->create();
        $product2 = Product::factory()->create();
        $response = $this->get('api/products');

        $response->assertStatus(200);
        $response->assertJsonFragment(['id' => $product1->id]);
        $response->assertJsonFragment(['id' => $product2->id]);
    }

    public function testCreateProduct()
    {
        $data = [
            'name' => 'New Product',
            'description' => 'This is a new product',
            'img' => 'This is a new product',
            'price' => 9.99
        ];

        $response = $this->postJson('/api/products', $data);

        $response->assertStatus(201)
            ->assertJson([
                'name' => 'New Product',
                'description' => 'This is a new product',
                'img' => 'This is a new product',
                'price' => 9.99
            ]);

        $this->assertDatabaseHas('products', $data);
    }

}
