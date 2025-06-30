<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),
            'number' => strtoupper(Str::random(12)),
            'total_price' => $this->faker->randomFloat(2, 20, 2000),
            'status' => $this->faker->randomElement(['pending', 'processing', 'completed', 'declined']),
            'shipping_price' => $this->faker->randomFloat(2, 0, 50),
            'notes' => $this->faker->optional()->sentence,
        ];
    }
}
