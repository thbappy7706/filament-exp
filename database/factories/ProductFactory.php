<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->words(3, true);

        return [
            'brand_id' => Brand::factory(),
            'name' => ucfirst($name),
            'slug' => Str::slug($name),
            'sku' => strtoupper(Str::random(10)),
            'image' => $this->faker->imageUrl(640, 480, 'products'),
            'description' => $this->faker->paragraph,
            'quantity' => $this->faker->numberBetween(1, 500),
            'price' => $this->faker->randomFloat(2, 5, 500),
            'is_visible' => $this->faker->boolean(80),
            'is_featured' => $this->faker->boolean(20),
            'type' => $this->faker->randomElement(['deliverable', 'downloadable']),
            'published_at' => $this->faker->optional()->date(),
        ];
    }
}
