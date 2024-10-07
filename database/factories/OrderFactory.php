<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {    
        return [
            'user_id' =>$this->faker->randomElement([1,2,3,4,5,6,7,8,9,10,12,13]),
            'order_item_id' =>$this->faker->randomElement([1,2,3,4,5,6,7,8,9,10,12,13]),
            'date' => $this->faker->date(),
            'information' => $this->faker->sentence(),
            'total' => $this->faker->randomFloat(2, 10, 1000),
        ];
    }
}
