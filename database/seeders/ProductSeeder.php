<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::all()->each(function(Category $category){
            for($i = 0; $i < 5; $i++){
                $category->products()->create([
                    'name' => "Products of $category->name",
                    'price' => rand(100, 1000),
                ]);
            }
        });
    }
}
