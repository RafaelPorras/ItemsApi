<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BoardGame;
use App\Models\Book;
use App\Models\VideoGame;
use App\Models\Item;
use App\Models\Film;
use App\Models\MusicalFormat;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         
         Item::factory(50)->create();
        
    }
}
