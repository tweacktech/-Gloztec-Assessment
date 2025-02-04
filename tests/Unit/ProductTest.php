<?php

namespace Tests\Unit;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function test_counts_products()
    {
        // Insert a product into the database
        Product::create([
            'name' => 'Test Product',
            'stock' => 10, 
            'price' => 100,
        ]);

        // Count the number of products
        $productCount = Product::count();

        // Assert that there is 1 product in the database
        $this->assertEquals(1, $productCount, "Product count should be 1 after inserting a product.");
    }
}
