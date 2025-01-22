<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\VideoGame;
use App\Traits\ApiResponser;
use App\Traits\DataResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

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
            'genre_id' => 'required|max:255',
            'category_id' => 'required|integer|min:1',

            /**
             * video_games data table
             */
            'system_requirement' => 'required|max:255', 
            'platform' => 'required|max:255',
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
            $videoGame = VideoGame::create([
                'system_requirement' => $request->system_requirement,
                'platform' => $request->platform,
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
                'itemable_id' => $videoGame->id,
                'itemable_type' => VideoGame::class,
            ]);

            DB::commit();

            return $this->successResponse($item, Response::HTTP_CREATED);
        }
        catch(\Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage(), 
            Response::HTTP_INTERNAL_SERVER_ERROR);
        }

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
