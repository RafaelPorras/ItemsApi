<?php

namespace Database\Factories;

use App\Models\Film;
use Illuminate\Database\Eloquent\Factories\Factory;

class FilmFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Film::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'format' => $this->faker->randomElement(['DVD', 'Blu-Ray', 'VHS']),
            'age_rating' => $this->faker->randomElement(['G', 'PG', 'PG-13', 'R', 'NC-17']),
            'duration' => $this->faker->numberBetween(60, 180),
            'subtitles' => $this->faker->boolean(),
        ];
    }
}