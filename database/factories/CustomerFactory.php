<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->unique()->phoneNumber,
            'date_of_birth' => $this->faker->date('Y-m-d', '-18 years'),
            'address' => $this->faker->address,
            'zip_code' => $this->faker->postcode,
            'city' => $this->faker->city,
        ];
    }
}
