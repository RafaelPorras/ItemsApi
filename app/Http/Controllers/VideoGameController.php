<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VideoGameController extends Controller
{
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
 
    }



    /**
     * Create an instance of the video game
     * @return Illuminate\Http\Response
     */
    public function store(Request $request) {

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
