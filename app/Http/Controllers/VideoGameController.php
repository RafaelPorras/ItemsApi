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

        //Validate the request
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
        $videoGame = VideoGame::with('item')->findOrFail($videoGame);

        return $this->successResponse($videoGame);
    }

    /**
     * Update an instance of the video game
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $videoGame) {
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
          'genre_id' => 'max:255',
          'category_id' => 'integer|min:1',

          /**
           * video_games data table
           */
          'system_requirement' => 'max:255', 
          'platform' => 'max:255',
      ];

      //Validate the request
      $this->validate($request, $rules);

      // Find the video gameº
      $videoGame = VideoGame::with('item')->findOrFail($videoGame);

      //Attributes for the video game
      $videoGameAttributes = ['system_requirement', 'platform'];

      //Attributes for the item
      $itemAttributes = [
        'title', 'description', 'owner', 'language', 
        'adquisition_date', 'status', 'publication_year', 
        'collection', 'author_id', 'editorial_id', 
        'genre_id', 'category_id'
        ];

       // Track if any changes were made
       $changesMade = false;
    
       // Update book attributes
       foreach ($videoGameAttributes as $attribute) {
           if ($request->has($attribute) && 
               $videoGame->$attribute !== 
               $request->input($attribute)) {
               $videoGame->$attribute = 
               $request->input($attribute);
               $changesMade = true;
           }
       }
   
       // Update related item attributes
       foreach ($itemAttributes as $attribute) {
           if ($request->has($attribute) && 
               $videoGame->item->$attribute !== 
               $request->input($attribute)) {
               $videoGame->item->$attribute = 
               $request->input($attribute);
               $changesMade = true;
           }
       }

       // Check if any changes were made
       if (!$changesMade) {
           return $this->errorResponse('At least one value must change', 
           Response::HTTP_UNPROCESSABLE_ENTITY);
       }

       // Save the changes
       try{
           DB::transaction(function () use ($videoGame) {
               // Save the video game
               $videoGame->save();

               // Save the related item 
               $videoGame->item->save();
   
           });

           return $this->successResponse($videoGame);
           
       }
       catch(\Exception $e){
           return $this->errorResponse($e->getMessage(), 
           Response::HTTP_INTERNAL_SERVER_ERROR);
       }

    }

    /**
     * Delete an instance of the video game
     * @return Illuminate\Http\Response
     *
     */
    public function destroy($videoGame) {

        //Find the video game
        $videoGame = VideoGame::with('item')->findOrFail($videoGame);

        //With the transaction method, 
        //we ensure that if an error occurs, 
        //the database will rollback to 
        //its previous state.
        DB::beginTransaction();

        try{

            //Delete the related item first
            $videoGame->item->delete();

            //Delete the video game
            $videoGame->delete();

            //Commit the transaction
            DB::commit();

            return $this->successResponse($videoGame);

        }
        catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), 
            Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }



    
}
