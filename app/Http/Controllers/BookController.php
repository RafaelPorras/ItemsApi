<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Book;
use App\Traits\ApiResponser;
use App\Traits\DataResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;


class BookController extends Controller
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
     * Return the list of books
     * @return Illuminate\Http\Response
     */
    public function index() {

        $items = Item::all();

        $books = $this->dataStructure($items)['books'];

        return $this->successResponse($books);


    }



    /**
     * Create an instance of the book
     * @return Illuminate\Http\Response
     */
    public function store(Request $request) {

        /**
         * Rules for the request
         */

        $rules = [
             /**
              *  item data table
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
             * books data table
             */
            'isbn' => 'required|max:255',
            'pages_number' => 'required|integer|min:1',
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
            $book = Book::create([
                'isbn' => $request->isbn,
                'pages_number' => $request->pages_number,
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
                'itemable_id' => $book->id,
                'itemable_type' => Book::class,
            ]);

        DB::commit();

            return $this->successResponse($item, Response::HTTP_CREATED);
       }

        catch(\Exception $e){
            DB::rollBack();
            return $this->errorResponse('Error creating book', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
     


    }

        /**
     * Return an instance of the book
     * @return Illuminate\Http\Response
     */
    public function show($book) {
        $book = Book::with('item')->findOrFail($book);

        return $this->successResponse($book);
    }

    /**
     * Update an instance of the book
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $book) {

        /**
         * Rules for the request
         */

         $rules = [
            /**
             *  item data table
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
             * books data table
             */
            'isbn' => 'max:255',
            'pages_number' => 'integer|min:1',
        ];

        // Validate the request
        $this->validate($request, $rules);

        // Find the book
        $book = Book::with('item')->findOrFail($book);

        // Attributes for the book
        $bookAttributes = ['isbn', 'pages_number'];

        // Attributes for the related item
        $itemAttributes = [
            'title', 'description', 'owner', 'language', 
            'adquisition_date', 'status', 'publication_year', 
            'collection', 'author_id', 'editorial_id', 
            'genre_id', 'category_id'
        ];
    
        // Track if any changes were made
        $changesMade = false;
    
        // Update book attributes
        foreach ($bookAttributes as $attribute) {
            if ($request->has($attribute) && 
                $book->$attribute !== 
                $request->input($attribute)) {
                $book->$attribute = 
                $request->input($attribute);
                $changesMade = true;
            }
        }
    
        // Update related item attributes
        foreach ($itemAttributes as $attribute) {
            if ($request->has($attribute) && 
                $book->item->$attribute !== 
                $request->input($attribute)) {
                $book->item->$attribute = 
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
            DB::transaction(function () use ($book) {
                // Save the book
                $book->save();

                // Save the related item first
                $book->item->save();
    
            });

            return $this->successResponse($book);

        }
        catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), 
            Response::HTTP_INTERNAL_SERVER_ERROR);
        }




    }

    /**
     * Delete an instance of the book
     * @return Illuminate\Http\Response
     *
     */
    public function destroy($book) {

        //Find the book
        $book = Book::with('item')->findOrFail($book);

        //With the transaction method, 
        //we ensure that if an error occurs, 
        //the database will rollback to 
        //its previous state.
        DB::beginTransaction();

        try{

            //Delete the related item
            $book->item->delete();

            //delete the book
            $book->delete();

            //Commit the transaction
            DB::commit();

            return $this->successResponse($book);


        }
        catch(\Exception $e){
            DB::rollBack();
            return $this->errorResponse($e->getMessage(), 
            Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }



    
}
