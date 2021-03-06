<?php

namespace Database\Factories;

use App\Models\ProductFavorite;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFavoriteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductFavorite::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween($min = 1, $max = 10),
            'product_id' => $this->faker->numberBetween($min = 1, $max = 10),
            'favorite' => $this->faker->boolean,
        ];
    }
}
