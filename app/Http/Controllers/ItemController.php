<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Traits\ApiResponser;
use App\Traits\DataResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;




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
        return $this->errorResponse('You have to use the specific controller for each item type', Response::HTTP_NOT_FOUND);
    }

        /**
     * Return an instance of the item
     * @return Illuminate\Http\Response
     */
    public function show($item) {
        $item = Item::findOrFail($item);

        return $this->successResponse($item);
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
