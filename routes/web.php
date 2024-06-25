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

// Default route returning the application version
$router->get('/', function () use ($router) {
    return $router->app->version();
});

// Route to register a new user
$router->post('/register', 'AuthController@register');

// Route to authenticate and log in a user
$router->post('/login', 'AuthController@login');

// Routes protected with JWT authentication middleware
$router->group(['middleware' => 'jwt.auth'], function () use ($router) {
    // Route to get all users (protected)
    $router->get('/users', 'AuthController@showAllUsers');

    // Route to delete a user by ID (protected)
    $router->delete('/users/{id}', 'AuthController@deleteUser');

    // Route to update a user by ID (protected)
    $router->put('/users/{id}', 'AuthController@updateUser');
});

// Route to get all movies
$router->get('/movies', 'MovieController@getMovies');

// Route to search movies by title
$router->get('/movies/search', 'MovieController@getMoviesByTitle');

// Route to check streaming availability
$router->get('/streaming', 'StreamingController@getStreamingAvailability');

// Route to get available countries for streaming
$router->get('/streaming/countries', 'StreamingController@getAvailableCountries');

// Route to get theatres by zip code and radius
$router->get('/theatres', 'TheatreController@getTheatres');

// Route to get opening movies, optionally filtered by country ID
$router->get('/opening-movies', 'TheatreController@getOpeningMovies');
