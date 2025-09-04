<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public static $wrap = 'value';
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'stock' => $this->stock,
            'category_id' => new CategorySimpleResource($this->whenLoaded('category')), // CONDITIONAL ATTRIBUTES
            'is_expensive' => $this->when($this->price > 100, true, false), // CONDITIONAL ATTRIBUTES
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
