<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'category' => $this->category->name,
            'size' => $this->size,
            'weight' => $this->weight,
            'price' => $this->price,
            'image' => $this->image,
            'year' => $this->year,
            'description' => $this->description,
            'isActive' => $this->is_active,
        ];
    }
}
