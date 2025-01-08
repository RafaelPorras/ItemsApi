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

$router->get('/boardGames', 'BoardGameController@index');
$router->post('/boardGames', 'BoardGameController@store');
$router->get('/boardGames/{boardGame}', 'BoardGameController@show');
$router->put('/boardGames/{boardGame}', 'BoardGameController@update');
$router->patch('/boardGames/{boardGame}', 'BoardGameController@update');
$router->delete('/boardGames/{boardGame}', 'BoardGameController@destroy');

$router->get('/books', 'BookController@index');
$router->post('/books', 'BookController@store');
$router->get('/books/{book}', 'BookController@show');
$router->put('/books/{book}', 'BookController@update');
$router->patch('/books{book}', 'BookController@update');
$router->delete('/books/{book}', 'BookController@destroy');

$router->get('/films', 'FilmController@index');
$router->post('/films', 'FilmController@store');
$router->get('/films/{film}', 'FilmController@show');
$router->put('/films/{film}', 'FilmController@update');
$router->patch('/films/{film}', 'FilmController@update');
$router->delete('/films/{film}', 'FilmController@destroy');

$router->get('/musicFormats', 'MusicFormatController@index');
$router->post('/musicFormats', 'MusicFormatController@store');
$router->get('/musicFormats/{musicFormat}', 'MusicFormatController@show');
$router->put('/musicFormats/{musicFormat}', 'MusicFormatController@update');
$router->patch('/musicFormats/{musicFormat}', 'MusicFormatController@update');
$router->delete('/musicFormats/{musicFormat}', 'MusicFormatController@destroy');


$router->get('/videoGames', 'VideoGameController@index');
$router->post('/videoGames', 'VideoGameController@store');
$router->get('/videoGames/{videoGame}', 'VideoGameController@show');
$router->put('/videoGames/{videoGame}', 'VideoGameController@update');
$router->patch('/videoGames/{videoGame}', 'VideoGameController@update');
$router->delete('/videoGames/{videoGame}', 'VideoGameController@destroy');






