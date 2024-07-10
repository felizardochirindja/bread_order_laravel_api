<?php

namespace Database\Factories;

use App\Models\Month;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MonthlyOrder>
 */
class MonthlyOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'year' => fake()->year(),
            'month' => Month::factory(),
            'remain' => fake()->randomFloat(2, 0, 1500),
            'status' => fake()->randomElement(['overdue', 'pending', 'installments', 'paid']),
            'product' => Product::factory(),
        ];
    }
}
