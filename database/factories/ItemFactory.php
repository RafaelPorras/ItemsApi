<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Item::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $relatedModel = $this->getRandomRelateModel();

        return [
            'title' => $this->faker->sentence(3,true),
            'description' => $this->faker->sentence(6,3),
            'owner' => $this->faker->name,
            'language' => $this->faker->languageCode,
            'adquisition_date' => $this->faker->date(),
            'status' => $this->faker->randomElement(['available', 'unavailable']),
            'collection' => $this->faker->sentence(3,true),
            'publication_year' => $this->faker->year(),
            'author_id' => $this->faker->numberBetween(1,10),
            'editorial_id' => $this->faker->numberBetween(1,10),
            'genre_id' => $this->faker->numberBetween(1,10),
            'category_id' => null,
            'itemable_id' => $relatedModel->id,
            'itemable_type' => get_class($relatedModel),

        ];
    }

    public function getRandomRelateModel(){
       
            $number = $this->faker->numberBetween(1,5);

            return match ($number) {
                1 => \App\Models\Book::factory()->create(),
                2 => \App\Models\Film::factory()->create(),
                3 => \App\Models\BoardGame::factory()->create(),
                4 => \App\Models\VideoGame::factory()->create(),
                5 => \App\Models\MusicalFormat::factory()->create(),
            };

    }
}
