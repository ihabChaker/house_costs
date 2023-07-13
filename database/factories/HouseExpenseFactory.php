<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HouseExpense>
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
            'expense_name' => $this->faker->word(),
            'amount' => $this->faker->numberBetween(2, 1000),
            'house_name' => ['house1', 'house2'][$this->faker->numberBetween(0, 1)],
            'date' => $this->faker->date(),
            'spender_id' => Employee::pluck('id')->random(),
        ];
    }
}