<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Traits\ApiResponser;
use App\Traits\DataResponser;

class VideoGameController extends Controller
{
    use ApiResponser, DataResponser;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
        
    }

    /**
     * Return the list of video games
     * @return Illuminate\Http\Response
     */
    public function index() {
        $items = Item::all();

        $videoGames = $this->dataStructure($items)['video_games'];

        return $this->successResponse($videoGames);
    }



    /**
     * Create an instance of the video game
     * @return Illuminate\Http\Response
     */
    public function store(Request $request) {

    }

        /**
     * Return an instance of the video game
     * @return Illuminate\Http\Response
     */
    public function show($videoGame) {
   
    }

    /**
     * Update an instance of the video game
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $videoGame) {

    }

    /**
     * Delete an instance of the video game
     * @return Illuminate\Http\Response
     *
     */
    public function destroy($videoGame) {

    }



    
}
