<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class Order_itemsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'product_id' => $this->randomElement([1,2,3.4,5,6,7,8,9,10,11,12,13]),
            'order_id' => $this->randomElement([1,2,3.4,5,6,7,8,9,10,11,12,13]),
            'quantity' => $this->faker->randomNumber(5, true),
            'amount' => $this->faker->randomNumber(10, true),
        ];
    }
}
