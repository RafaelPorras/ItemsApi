<?php

namespace App\Http\Controllers;

use App\Models\BoardGame;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use App\Traits\DataResponser;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Exception;

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

        /**
         * Rules for the request
         */

        $rules = [
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'owner' => 'required|max:255',
            'language' => 'required|max:255',
            'adquisition_date' => 'required|date',
            'status' => 'required|max:255',
            'publication_year' => 'required|integer|min:1',
            'collection' => 'max:255',
            'author_id' => 'required|integer|min:1',
            'editorial_id' => 'required|integer|min:1',
            'genre_id' => 'required|integer|min:1',
            'category_id' => 'required|integer|min:1',
            'duration' => 'required|integer|min:1',
            'min_players' => 'required|integer|min:1',
            'max_players' => 'required|integer|min:1',
        ];

        $this->validate($request, $rules);

        /**
         * With the transaction method, 
         * we ensure that if an error occurs, 
         * the database will rollback to 
         * its previous state.
         */
        DB::beginTransaction();

        try{
            $boardGame = BoardGame::create([
                'duration'=>$request->input('duration'),
                'min_players'=>$request->input('min_players'),
                'max_players'=>$request->input('max_players'),
            ]);
            
            $item = Item::create([
                'title' => $request->title,
                'description' => $request->description,
                'owner' => $request->owner,
                'language' => $request->language,
                'adquisition_date' => $request->adquisition_date,
                'status' => $request->status,
                'publication_year' => $request->publication_year,            
                'collection' => $request->collection,
                'author_id' => $request->author_id,
                'editorial_id' => $request->editorial_id,
                'genre_id' => $request->genre_id,
                'category_id' => $request->category_id,
                'itemable_id' => $boardGame->id,
                'itemable_type' => BoardGame::class,
            
            ]);

            DB::commit();
            return $this->successResponse($item, Response::HTTP_CREATED);
        }
        catch(Exception $e){
            DB::rollBack();
            return $this->errorResponse($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }


        
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
