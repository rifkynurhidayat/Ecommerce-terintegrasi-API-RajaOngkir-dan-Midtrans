<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'order_id' => $this->faker->randomElement([2,3,4,5,6,7,8,9,10,12,13,14]),
            'is_paid'  => $this->faker->randomElement(['0', '1']),
            'total' => $this->faker->randomNumber(8, true),
        ];
    }
}
