<?php

namespace Tests\Feature;

use App\Models\Category;
use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    // resources
    public function testApiCategories(): void
    {
        $this->seed(CategorySeeder::class);
        $category = Category::first();

        $this->get("/api/categories/$category->id")
        ->assertStatus(200)
        ->assertJson([
            'data' => [
                'id' => $category->id,
                'name' => $category->name,
                'created_at' => $category->created_at->toJson(),
                'updated_at' => $category->updated_at->toJson(),
            ]
            ]);
    }
}
