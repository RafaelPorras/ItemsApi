<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BoardGameController extends Controller
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
     * Return the list of board games
     * @return Illuminate\Http\Response
     */
    public function index() {
 
    }



    /**
     * Create an instance of the board game
     * @return Illuminate\Http\Response
     */
    public function store(Request $request) {

    }

        /**
     * Return an instance of the board 
     * @return Illuminate\Http\Response
     */
    public function show($boardGame) {
   
    }

    /**
     * Update an instance of the board game
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $boardGame) {

    }

    /**
     * Delete an instance of the board 
     * @return Illuminate\Http\Response
     *
     */
    public function destroy($boardGame) {

    }



    
}
