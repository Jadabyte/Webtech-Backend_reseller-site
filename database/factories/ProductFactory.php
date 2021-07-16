<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween($min = 1, $max = 10),
            'product_category_id' => $this->faker->numberBetween($min = 1, $max = 10),
            'title' => $this->faker->text($maxNbChars = 10),
            'description' => $this->faker->text($maxNbChars = 200),
            'price' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = NULL),
        ];
    }
}
