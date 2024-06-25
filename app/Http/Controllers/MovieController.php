<?php

namespace App\Http\Controllers;

use App\Services\MovieService;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    protected $movieService;

    // Constructor to inject MovieService dependency
    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    // Method to get all movies
    public function getMovies()
    {
        // Get the list of movies from the MovieService
        $data = $this->movieService->getMovies();
        
        // Return the list of movies as a JSON response
        return response()->json($data);
    }

    // Method to get movies by title
    public function getMoviesByTitle(Request $request)
    {
        // Get the title from the request
        $title = $request->input('title');
        
        // Check if title parameter is provided
        if ($title) {
            // Get the movies with the given title from the MovieService
            $data = $this->movieService->getMoviesByTitle($title);
            
            // Return the list of movies as a JSON response
            return response()->json($data);
        } else {
            // Return an error response if title is not provided
            return response()->json(['error' => 'Title parameter is required'], 400);
        }
    }
}
