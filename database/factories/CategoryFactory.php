<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $name = ucfirst($this->faker->word); // no unique()

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'parent_id' => null,
            'is_visible' => $this->faker->boolean(70),
            'description' => $this->faker->paragraph,
        ];
    }

//    public function configure(): CategoryFactory
//    {
//        return $this->afterMaking(function ($model) {
//            while ($model::where('slug', $model->slug)->exists()) {
//                $model->slug = Str::slug($model->name) . '-' . Str::random(8);
//            }
//        });
//    }
}
