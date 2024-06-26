<?php

namespace Tests\Feature;

use App\Models\Price;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_contains_empty_table(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/products');

        $response->assertStatus(200);
        $response->assertSee(__('Er zijn geen producten.'));
    }

    public function test_homepage_contains_non_empty_table(): void
    {
        $user = User::factory()->create();
        $product = Product::create([
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

        $response = $this->actingAs($user)->get('/products');

        $response->assertStatus(200);
        $response->assertDontSee(__('Er zijn geen producten.'));
        $response->assertSee('melk');
        $response->assertViewHas('products', function ($collection) use ($product) {
            return $collection->contains($product);
        });
    }
    public function test_homepage_products_table_doesnt_contain_11th_record(): void
    {
        $user = User::factory()->create();
        $products = Product::factory(11)->create();
        $lastProduct = $products->last();

        Price::factory(5)->create();

        $response = $this->actingAs($user)->get('/products');

        $response->assertStatus(200);
        $response->assertDontSee(__('Er zijn geen producten.'));
        $response->assertViewHas('products', function ($collection) use ($lastProduct) {
            return $collection->contains($lastProduct);
        });
    }
    public function test_admin_can_access_product_create_page(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $products = Product::factory(11)->create();
        $lastProduct = $products->last();

        Price::factory(5)->create();

        $response = $this->actingAs($admin)->get('/products');

        $response->assertStatus(200);
        $response->assertDontSee(__('Er zijn geen producten.'));
        $response->assertViewHas('products', function ($collection) use ($lastProduct) {
            return $collection->contains($lastProduct);
        });
    }

    private function test_admin_sees_products(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $response = $this->actingAs($admin)->get('/products');
        $response->assertStatus(302);
    }

    private function test_product_actually_removed(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $response = $this->actingAs($admin)->get('/products');
        $response->assertStatus(302);
        $this->assertCount(0, Product::count());
    }

    private function test_working_api(): void
    {
        $response = $this->getJson('/api/products');
        $response->assertStatus(200);
    }

    public function test_unauthenticated_user_cannot_access_product_page(): void
    {
        $response = $this->get('/products');
        $response->assertRedirect('/login');

        $response->assertStatus(302);
    }
}
