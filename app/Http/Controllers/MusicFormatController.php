<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Traits\ApiResponser;
use App\Traits\DataResponser;

class MusicFormatController extends Controller
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
     * Return the list of music formats
     * @return Illuminate\Http\Response
     */
    public function index() {

        $items = Item::all();
        $music_formats = $this->dataStructure($items)['music'];
        
        return $this->successResponse($music_formats);
 
    }



    /**
     * Create an instance of the music format
     * @return Illuminate\Http\Response
     */
    public function store(Request $request) {

    }

        /**
     * Return an instance of the music format
     * @return Illuminate\Http\Response
     */
    public function show($musicFormat) {
   
    }

    /**
     * Update an instance of the music format
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $musicFormat) {

    }

    /**
     * Delete an instance of the music format
     * @return Illuminate\Http\Response
     *
     */
    public function destroy($musicFormat) {

    }



    
}
