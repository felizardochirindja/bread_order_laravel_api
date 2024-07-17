<?php

namespace Database\Factories;

use App\Models\Types\DailyOrderStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DailyOrder>
 */
class DailyOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'day' => fake()->numberBetween(1, 31),
            'total' => fake()->randomFloat(2, 9, 100),
            'quantity' => fake()->numberBetween(1, 10),
            'product_price' => fake()->randomFloat(2, 9, 12),
            'notes' => fake()->paragraph(),
            'status' => fake()->randomElement(DailyOrderStatus::cases()),
        ];
    }
}
