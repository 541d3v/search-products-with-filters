<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create test categories
        Category::factory()->count(3)->create();
        
        // Create test products
        Product::factory()->count(10)->create();
    }

    public function test_can_get_products_list(): void
    {
        $response = $this->getJson('/api/products');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'price', 'category_id', 'in_stock', 'rating'],
                ],
                'meta' => ['current_page', 'last_page', 'per_page', 'total'],
            ]);
    }

    public function test_pagination_works(): void
    {
        $response = $this->getJson('/api/products?page=1&per_page=5');

        $response->assertStatus(200);
        $data = $response->json();
        
        $this->assertCount(5, $data['data']);
        $this->assertEquals(1, $data['meta']['current_page']);
        $this->assertEquals(5, $data['meta']['per_page']);
    }

    public function test_search_by_name(): void
    {
        // Create a product with a specific name
        Product::create([
            'name' => 'Unique Test Product',
            'price' => 99.99,
            'category_id' => 1,
            'in_stock' => true,
            'rating' => 4.5,
        ]);

        $response = $this->getJson('/api/products?q=Unique');

        $response->assertStatus(200);
        $data = $response->json();
        
        $this->assertGreaterThanOrEqual(1, count($data['data']));
    }

    public function test_filter_by_price_range(): void
    {
        $response = $this->getJson('/api/products?price_from=100&price_to=500');

        $response->assertStatus(200);
        $data = $response->json();
        
        foreach ($data['data'] as $product) {
            $this->assertGreaterThanOrEqual(100, $product['price']);
            $this->assertLessThanOrEqual(500, $product['price']);
        }
    }

    public function test_filter_by_category(): void
    {
        $category = Category::first();
        
        $response = $this->getJson('/api/products?category_id='.$category->id);

        $response->assertStatus(200);
        $data = $response->json();
        
        foreach ($data['data'] as $product) {
            $this->assertEquals($category->id, $product['category_id']);
        }
    }

    public function test_filter_by_stock_status(): void
    {
        $response = $this->getJson('/api/products?in_stock=true');

        $response->assertStatus(200);
        $data = $response->json();
        
        foreach ($data['data'] as $product) {
            $this->assertTrue($product['in_stock']);
        }
    }

    public function test_filter_by_rating(): void
    {
        $response = $this->getJson('/api/products?rating_from=4');

        $response->assertStatus(200);
        $data = $response->json();
        
        foreach ($data['data'] as $product) {
            $this->assertGreaterThanOrEqual(4, $product['rating']);
        }
    }

    public function test_sort_by_price_ascending(): void
    {
        $response = $this->getJson('/api/products?sort=price_asc&per_page=100');

        $response->assertStatus(200);
        $data = $response->json();
        
        $prices = array_map(fn($p) => $p['price'], $data['data']);
        $sorted = $prices;
        sort($sorted);
        
        $this->assertEquals($sorted, $prices);
    }

    public function test_sort_by_price_descending(): void
    {
        $response = $this->getJson('/api/products?sort=price_desc&per_page=100');

        $response->assertStatus(200);
        $data = $response->json();
        
        $prices = array_map(fn($p) => $p['price'], $data['data']);
        $sorted = $prices;
        rsort($sorted);
        
        $this->assertEquals($sorted, $prices);
    }

    public function test_sort_by_rating_descending(): void
    {
        $response = $this->getJson('/api/products?sort=rating_desc&per_page=100');

        $response->assertStatus(200);
        $data = $response->json();
        
        $ratings = array_map(fn($p) => $p['rating'], $data['data']);
        $sorted = $ratings;
        rsort($sorted);
        
        $this->assertEquals($sorted, $ratings);
    }

    public function test_validation_invalid_price_range(): void
    {
        $response = $this->getJson('/api/products?price_from=abc');

        $response->assertStatus(422);
    }

    public function test_validation_price_to_less_than_price_from(): void
    {
        $response = $this->getJson('/api/products?price_from=500&price_to=100');

        // Should still return 200 since per_page validation doesn't include this constraint
        // The scope will just filter correctly
        $response->assertStatus(200);
    }

    public function test_validation_invalid_category_id(): void
    {
        $response = $this->getJson('/api/products?category_id=99999');

        $response->assertStatus(422);
    }

    public function test_validation_invalid_per_page(): void
    {
        $response = $this->getJson('/api/products?per_page=101');

        $response->assertStatus(422);
    }

    public function test_validation_invalid_sort(): void
    {
        $response = $this->getJson('/api/products?sort=invalid_sort');

        $response->assertStatus(422);
    }
}
