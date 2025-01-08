<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Traits\ApiResponser;
use App\Traits\DataResponser;

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

    }

        /**
     * Return an instance of the film
     * @return Illuminate\Http\Response
     */
    public function show($film) {
   
    }

    /**
     * Update an instance of the film
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $film) {

    }

    /**
     * Delete an instance of the film
     * @return Illuminate\Http\Response
     *
     */
    public function destroy($film) {

    }



    
}
