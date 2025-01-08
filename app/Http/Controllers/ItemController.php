<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use App\Traits\DataResponser;

use App\Models\Item;

class ItemController extends Controller
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
     * Return the list of items
     * @return Illuminate\Http\Response
     */
    public function index() {
 
        $items = Item::all();

        $items = $this->dataStructure($items);

        return $this->successResponse($items);
    }



    /**
     * Create an instance of the item
     * @return Illuminate\Http\Response
     */
    public function store(Request $request) {

    }

        /**
     * Return an instance of the item
     * @return Illuminate\Http\Response
     */
    public function show($item) {
   
    }

    /**
     * Update an instance of the item
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $item) {

    }

    /**
     * Delete an instance of the item
     * @return Illuminate\Http\Response
     *
     */
    public function destroy($item) {

    }



    
}
