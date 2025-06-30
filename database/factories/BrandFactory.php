<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BrandFactory extends Factory
{
    protected $model = Brand::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->company;

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'url' => $this->faker->url,
            'primary_hex' => $this->faker->hexColor,
            'is_visible' => $this->faker->boolean(70),
            'description' => $this->faker->paragraph,
        ];
    }
}
