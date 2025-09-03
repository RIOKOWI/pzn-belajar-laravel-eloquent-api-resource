<?php

namespace Tests\Feature;

use App\Models\Product;
use Tests\TestCase;
use Database\Seeders\ProductSeeder;
use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    
    // data wrap
    public function testDataWrap()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $product = Product::first();

        $this->get("/api/product/$product->id")
        ->assertStatus(200)
        ->assertJson([
            'value' => [
                
                'name' => $product->name,
                'category_id' => [
                    'id' => $product->category->id,
                    'name' => $product->category->name,
                ],
                'price' => $product->price,
                'created_at' => $product->created_at->toJson(),
                'updated_at' => $product->updated_at->toJson(),
                

            ]
        ]);

    }
}
