<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Models\Item;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/items', 'ItemController@index');
$router->post('/items', 'ItemController@store');
$router->get('/items/{item}', 'ItemController@show');
$router->put('/items/{item}', 'ItemController@update');
$router->patch('/items/{item}', 'ItemController@update');
$router->delete('/items/{item}', 'ItemController@destroy');

$router->get('/boardgame', 'BoardGameController@index');
$router->post('/boardgame', 'BoardGameController@store');
$router->get('/boardgame/{boardGame}', 'BoardGameController@show');
$router->put('/boardgame/{boardGame}', 'BoardGameController@update');
$router->patch('/boardgame/{boardGame}', 'BoardGameController@update');
$router->delete('/boardgame/{boardGame}', 'BoardGameController@destroy');

$router->get('/book', 'BookController@index');
$router->post('/book', 'BookController@store');
$router->get('/book/{book}', 'BookController@show');
$router->put('/book/{book}', 'BookController@update');
$router->patch('/book/{book}', 'BookController@update');
$router->delete('/book/{book}', 'BookController@destroy');

$router->get('/film', 'FilmController@index');
$router->post('/film', 'FilmController@store');
$router->get('/film/{film}', 'FilmController@show');
$router->put('/film/{film}', 'FilmController@update');
$router->patch('/film/{film}', 'FilmController@update');
$router->delete('/film/{film}', 'FilmController@destroy');

$router->get('/musicformat', 'MusicFormatController@index');
$router->post('/musicformat', 'MusicFormatController@store');
$router->get('/musicformat/{musicFormat}', 'MusicFormatController@show');
$router->put('/musicformat/{musicFormat}', 'MusicFormatController@update');
$router->patch('/musicformat/{musicFormat}', 'MusicFormatController@update');
$router->delete('/musicformat/{musicFormat}', 'MusicFormatController@destroy');


$router->get('/videogame', 'VideoGameController@index');
$router->post('/videogame', 'VideoGameController@store');
$router->get('/videogame/{videoGame}', 'VideoGameController@show');
$router->put('/videogame/{videoGame}', 'VideoGameController@update');
$router->patch('/videogame/{videoGame}', 'VideoGameController@update');
$router->delete('/videogame/{videoGame}', 'VideoGameController@destroy');






