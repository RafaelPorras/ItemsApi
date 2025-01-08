<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use App\Traits\DataResponser;

class BoardGameController extends Controller
{
    use ApiResponser,DataResponser; 

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Return the list of board games
     * @return Illuminate\Http\Response
     */
    public function index() {
 
        $items = Item::all();

        $boardGames = $this->dataStructure($items)['board_games'];

        return $this->successResponse($boardGames);
    }



    /**
     * Create an instance of the board game
     * @return Illuminate\Http\Response
     */
    public function store(Request $request) {

    }

        /**
     * Return an instance of the board 
     * @return Illuminate\Http\Response
     */
    public function show($boardGame) {
   
    }

    /**
     * Update an instance of the board game
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $boardGame) {

    }

    /**
     * Delete an instance of the board 
     * @return Illuminate\Http\Response
     *
     */
    public function destroy($boardGame) {

    }



    
}
