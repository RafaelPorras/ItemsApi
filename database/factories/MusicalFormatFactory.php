<?php

namespace Database\Factories;

use App\Models\MusicalFormat;
use Illuminate\Database\Eloquent\Factories\Factory;

class MusicalFormatFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MusicalFormat::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'format' => $this->faker->randomElement(['Vinyl', 'Cassette', 'CD']),
        ];
    }
}