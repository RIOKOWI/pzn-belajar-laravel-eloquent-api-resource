<?php

namespace Tests\Feature;

use App\Models\Product;
use Tests\TestCase;
use Database\Seeders\ProductSeeder;
use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function PHPUnit\Framework\assertContains;
use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\assertNull;

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
                'is_expensive' => $product->price > 100,
                'created_at' => $product->created_at->toJson(),
                'updated_at' => $product->updated_at->toJson(),
                

            ]
        ]);

    }

    // data wrap collection
    public function testDataWrapCollection(){
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $response = $this->get('/api/products')
        ->assertStatus(200);

        $names = $response->json("data.*.name"); // rio.*.name bisa juga tap harus ganti di productcollection
        for($i = 0; $i < 5; $i++){
            self::assertContains("Products $i of Food", $names);
        }

        for($i = 0; $i < 5; $i++){
            self::assertContains("Products $i of Gadget", $names);
        }
    }

    // data pagination
    public function testPagination(){
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $response = $this->get('/api/products-paging')
        ->assertStatus(200);

        assertNotNull($response->json('data'));
        assertNotNull($response->json('links'));
        assertNotNull($response->json('meta'));
    }

    // additional metadata statis
    // public function testDebug(){
    //     $this->seed([CategorySeeder::class, ProductSeeder::class]);

    //     $product = Product::first();
    //     $response = $this->get("/api/products-debug/$product->id")
    //     ->assertStatus(200)
    //     ->assertJson([
    //         "author" => "Rio Achyar",
    //         "data" => 
    //         [ 
    //             "id" => "$product->id",
    //             "name" => "$product->name",
    //             "price" => "$product->price"
    //         ]
    //     ]);
    // }

    // additional metadata dinamis
    public function testDebugDinamis(){
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $product = Product::first();
        $response = $this->get("/api/products-debug/dinamis/$product->id")
        ->assertStatus(200)
        ->assertJson([
            "data" => 
            [ 
                "author" => "Rio Achyar",
                "server_time" => now()->toDateTimeString(),
                "id" => "$product->id",
                "name" => "$product->name",
                "price" => "$product->price"
            ]
        ]);
    }
}
