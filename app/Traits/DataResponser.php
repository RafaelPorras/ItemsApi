<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait DataResponser {

    public function dataStructure($data){

        //Array to classify items
        $classifiedItems = [
            'books' => [],
            'films' => [],
            'board_games' => [],
            'video_games' => [],
            'music' => [],
        ];

        $data->each(function($item) use (&$classifiedItems) {
            //Get the properties of the itemable
            $itemableProperties = $item->itemable ? $item->itemable->toArray() : [];

            //Fusion of the item and itemable properties
            $mergedItem = array_merge($item->toArray(), $itemableProperties);

            //Remove the itemable property
            unset($mergedItem['itemable']);

            //Classify the item according to the itemable type
            switch($item->itemable_type){
                case 'App\Models\Book':
                    array_push($classifiedItems['books'], $mergedItem);
                    break;
                case 'App\Models\Film':
                    $classifiedItems['films'][] = $mergedItem;
                    break;
                case 'App\Models\BoardGame':
                    array_push($classifiedItems['board_games'], $mergedItem);
                    break;
                case 'App\Models\VideoGame':
                    array_push($classifiedItems['video_games'], $mergedItem);
                    break;
                case 'App\Models\MusicalFormat':
                    array_push($classifiedItems['music'], $mergedItem);
                    break;
            }
        });



        return $classifiedItems;

    }
}