<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Cviebrock\EloquentSluggable\Services\SlugService;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->words(5, true);

        return [
            'category_id' => rand(1, 3),
            'title' => ucwords($title),
            'slug' => SlugService::createSlug(Product::class, 'slug', $title),
            'image' => 'http://localhost:8000/images/products/product-1.jpg',
            'size' => fake()->randomElement(['M', 'L', 'XL']),
            'weight' => rand(100, 500),
            'price' => rand(100000, 500000),
            'description' => fake()->paragraph(3),
        ];
    }
}
