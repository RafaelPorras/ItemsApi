<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use App\Traits\DataResponser;

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

    }

        /**
     * Return an instance of the book
     * @return Illuminate\Http\Response
     */
    public function show($book) {
   
    }

    /**
     * Update an instance of the book
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $book) {

    }

    /**
     * Delete an instance of the book
     * @return Illuminate\Http\Response
     *
     */
    public function destroy($book) {

    }



    
}
