<?php

namespace Database\Factories;

use App\Models\VideoGame;
use Illuminate\Database\Eloquent\Factories\Factory;

class VideoGameFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = VideoGame::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'system_requirement' => $this->faker->text(100),
            'platform' => $this->faker->randomElement(['PS5','PS4', 'Xbox', 'PC']),
        
        ];
    }
}