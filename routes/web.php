<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('/register', 'AuthController@register');
$router->post('/login', 'AuthController@login');
$router->get('/users', ['uses' => 'AuthController@showAllUsers']);
$router->delete('/users/{id}', ['uses' => 'AuthController@deleteUser']);
$router->put('/users/{id}', ['uses' => 'AuthController@updateUser']);

$router->get('/movies', 'MovieController@getMovies');
$router->get('/movies/search', 'MovieController@getMoviesByTitle');

$router->get('/streaming', 'StreamingController@getStreamingAvailability');
$router->get('/streaming/countries', 'StreamingController@getAvailableCountries');

$router->get('/theatres', 'TheatreController@getTheatres');
$router->get('/opening-movies', 'TheatreController@getOpeningMovies');
