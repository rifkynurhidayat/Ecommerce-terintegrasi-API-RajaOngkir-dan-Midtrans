<?php

namespace Database\Factories;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'categories_id' => $this->faker->randomElement([1,2,3,4,5,6,7,8,9,10,12,13]),
            'product_name' => substr($this->faker->text(15), 0, 15),
            'product_price' => $this->faker->randomNumber(5, true),
            'product_stock' => $this->faker->randomFloat(1,20,30),
            'description' => $this->faker->text(),
        ];
    }
}
