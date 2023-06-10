<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class HouseExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'expense_name' => $this->faker->sentence,
            'amount' => $this->faker->randomFloat(2, 10, 1000),
            'house_name' => ['house1', 'house2'][$this->faker->numberBetween(0, 1)],
            'date' => $this->faker->date()
        ];
    }
}