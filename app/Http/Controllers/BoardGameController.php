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
            /**
             * items data table
             */
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

            /**
             * board_games data table
             */
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
        $boardGame = BoardGame::with('item')->findOrFail($boardGame);

        return $this->successResponse($boardGame);
    }

    /**
     * Update an instance of the board game
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $boardGame) {

        /**
         * Rules for the request
         */

         $rules = [
            /**
             * items data table
             */
            'title' => 'max:255',
            'description' => 'max:255',
            'owner' => 'max:255',
            'language' => 'max:255',
            'adquisition_date' => 'date',
            'status' => 'max:255',
            'publication_year' => 'integer|min:1',
            'collection' => 'max:255',
            'author_id' => 'integer|min:1',
            'editorial_id' => 'integer|min:1',
            'genre_id' => 'integer|min:1',
            'category_id' => 'integer|min:1',

            /**
             * board_games data table
             */
            'duration' => 'integer|min:1',
            'min_players' => 'integer|min:1',
            'max_players' => 'integer|min:1',
        ];

        //Validate the request
        $this->validate($request, $rules);

        //Find the board game
        $boardGame = BoardGame::with('item')->findOrFail($boardGame);

        //Attributes for the board game       
        $boardGameAttributes = ['min_players', 'max_players', 'duration'];

        //Attributes for the related item
        $itemAttributes = [
            'title', 'description', 'owner', 'language', 
            'adquisition_date', 'status', 'publication_year', 
            'collection', 'author_id', 'editorial_id', 
            'genre_id', 'category_id'
        ];

        //Initialize a flag to track changes
        $changesMade = false;

        //Update the board game attributes
        foreach($boardGameAttributes as $attribute){
            if($request->has($attribute) &&
                $boardGame->$attribute !== 
                $request->input($attribute)){
                $boardGame->$attribute = 
                $request->input($attribute);
                $changesMade = true;
            }
        }

        //Update the related item attributes
        foreach($itemAttributes as $attribute){
            if($request->has($attribute) &&
                $boardGame->item->$attribute !== 
                $request->input($attribute)){
                $boardGame->item->$attribute = 
                $request->input($attribute);
                $changesMade = true;
            }
        }

        //If no changes were made
        if(!$changesMade){
            return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        //Save the board game
        try{
            DB::transaction(function () use ($boardGame) {
                // Save the board game
                $boardGame->save();

                // Save the related item first
                $boardGame->item->save();
            });

            return $this->successResponse($boardGame);
        }
        catch(Exception $e){
            return $this->errorResponse($e->getMessage(),
             Response::HTTP_INTERNAL_SERVER_ERROR);
        }



    }

    /**
     * Delete an instance of the board 
     * @return Illuminate\Http\Response
     *
     */
    public function destroy($boardGame) {

        //Find the board game
        $boardGame = BoardGame::with('item')->findOrFail($boardGame);

        //Delete the related item
        $boardGame->item->delete();

        //Delete the board game
        $boardGame->delete();

        return $this->successResponse($boardGame);

    }



    
}
