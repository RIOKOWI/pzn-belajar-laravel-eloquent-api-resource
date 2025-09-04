<?php

use App\Http\Resources\CategoryCollection;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategorySimpleResource;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductDebugResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//resources
Route::get('/categories/{id}', function($id) {
    $category = Category::findOrFail($id);
    return new CategoryResource($category);
});

//resources collection
Route::get('/categories', function(){
    $categories = Category::all();
    return CategoryResource::collection($categories);
});

// custom resource collection
Route::get('/categories-custom', function(){
    $categories = Category::all();
    return new CategoryCollection($categories);
});

// nested resource
Route::get('/categories-nested', function(){
    $categories = Category::all();
    return new CategoryCollection($categories);
});

// DATA WRAP
Route::get('/product/{id}', function($id){
    $product = Product::find($id);
    return new ProductResource($product);
});

// DATA WRAP COLLECTION
Route::get('/products', function(){
    $products = Product::all();
    return new ProductCollection($products);
});

// pagination
Route::get('/products-paging', function(Request $request){
    $page = $request->get('page', 1);
    $products = Product::paginate(perPage : 2, page : $page);
    return new ProductCollection($products);
});

// additional metadata
Route::get('/products-debug/{id}', function($id){
    $products = Product::find($id);
    return new ProductDebugResource($products);
});