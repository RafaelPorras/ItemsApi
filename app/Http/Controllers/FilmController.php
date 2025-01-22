<?php

namespace App\Http\Controllers;



use App\Models\Item;
use App\Models\Film;
use App\Traits\ApiResponser;
use App\Traits\DataResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;



class FilmController extends Controller
{
    use ApiResponser;
    use DataResponser;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Return the list of films
     * @return Illuminate\Http\Response
     */
    public function index() {

        $items = Item::all();

        $films = $this->dataStructure($items)['films'];

        return $this->successResponse($films);
 
    }



    /**
     * Create an instance of the film
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
             * films data table
             */
            'format' => 'required|max:255',
            'age_rating' => 'required|max:255',
            'duration' => 'required|integer|min:1',
            'subtitles' => 'required|max:255',           
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
            $film = Film::create([
                'format' => $request->format,
                'age_rating' => $request->age_rating,
                'duration' => $request->duration,
                'subtitles' => $request->subtitles,
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
                'itemable_id' => $film->id,
                'itemable_type' => Film::class,
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
     * Return an instance of the film
     * @return Illuminate\Http\Response
     */
    public function show($film) {
        $film = Film::with('item')->findOrFail($film);

        return $this->successResponse($film);
    }

    /**
     * Update an instance of the film
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $film) {

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
             * films data table
             */
            'format' => 'max:255',
            'age_rating' => 'max:255',
            'duration' => 'integer|min:1',
            'subtitles' => 'max:255',           
         ];

         //Validate the request
         $this->validate($request, $rules);

         //Find the film
         $film = Film::with('item')->findOrFail($film);

         //Attributes for the film
         $filmAttributes = ['format', 'age_rating', 'duration', 'subtitles'];

         //Attributes for the related item
         $itemAttributes = [
            'title', 'description', 'owner', 'language', 
            'adquisition_date', 'status', 'publication_year', 
            'collection', 'author_id', 'editorial_id', 
            'genre_id', 'category_id'
         ];

         //Track if any changes were made
         $changesMade = false;

         //Update films attributes
         foreach($filmAttributes as $attribute){
            if($request->has($attribute) && 
               $film->$attribute !== 
               $request->input($attribute)){
               $film->$attribute = 
               $request->input($attribute);
               $changesMade = true;
            }
         }

         //Update related item attributes
         foreach ($itemAttributes as $attribute) {
            if ($request->has($attribute) && 
                $film->item->$attribute !== 
                $request->input($attribute)) {
                $film->item->$attribute = 
                $request->input($attribute);
                $changesMade = true;
            }
        }

        //Check if any changes were made
        if (!$changesMade) {
            return $this->errorResponse('At least one value must change', 
            Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        //Save the changes
        try{
            DB::transaction(function() use ($film) {
                //Save the film
                $film->save();

                //
                $film->item->save();
            });

            return $this->successResponse($film);

        }
        catch(\Exception $e) {
            return $this->errorResponse($e->getMessage(), 
            Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    /**
     * Delete an instance of the film
     * @return Illuminate\Http\Response
     *
     */
    public function destroy($film) {

        //Find the film
        $film = Film::with('item')->findOrFail($film);

        //With the transaction method, 
        //we ensure that if an error occurs, 
        //the database will rollback to 
        //its previous state.
        DB::beginTransaction();

        try{
            //Delete the related item first
            $film->item->delete();

            //Delete the film
            $film->delete();

            //
            DB::commit();

            return $this->successResponse($film);

        }
        catch(\Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage(), 
            Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }



    
}
