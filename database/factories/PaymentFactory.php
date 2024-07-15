<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'total' => fake()->randomFloat(2, 9, 1500),
            'paid_at' => fake()->dateTime(),
            'type' => fake()->randomElement(['periodic', 'daily']),
            'notes' => fake()->paragraph(1),
        ];
    }
}
