<?php

namespace Database\Factories;

use App\Models\BoardGame;
use Illuminate\Database\Eloquent\Factories\Factory;

class BoardGameFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BoardGame::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'duration' => $this->faker->randomDigit,
            'min_players' => $this->faker->randomDigit,
            'max_players' => $this->faker->randomDigit,
        ];
    }
}