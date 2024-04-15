<?php

namespace Tests\Feature;

use App\Models\Price;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_contains_empty_table(): void
    {
        $response = $this->get('/products');

        $response->assertStatus(200);
        $response->assertSee(__(key: 'Er zijn geen producten.'));
    }

    public function test_homepage_contains_non_empty_table(): void
    {
        Product::create([
            'name' => 'melk',
            'price_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Price::create([
            'price' => '1.20',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $response = $this->get('/products');

        $response->assertStatus(200);
        $response->assertDontSee(__(key: 'Er zijn geen producten.'));
        $response->assertSee(value: 'melk');
        $response->assertSee(value: '1.20');
    }
}
