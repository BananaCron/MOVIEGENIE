<?php

namespace App\Http\Controllers;

use App\Services\TheatreService;
use Illuminate\Http\Request;

class TheatreController extends Controller
{
    protected $theatreService;

    // Constructor to inject TheatreService dependency
    public function __construct(TheatreService $theatreService)
    {
        $this->theatreService = $theatreService;
    }

    // Method to get theatres based on zip code and radius
    public function getTheatres(Request $request)
    {
        // Get input parameters from the request
        $zipCode = $request->input('zipCode');
        $radius = $request->input('radius');
        $limit = $request->input('limit', 20); // Default limit to 20 if not provided
        $page = $request->input('page', 1); // Default page to 1 if not provided

        // Check if zipCode and radius are provided
        if (!$zipCode || !$radius) {
            // Return an error response if either zipCode or radius is missing
            return response()->json(['error' => 'zipCode and radius are required'], 400);
        }

        // Get the list of theatres from the TheatreService
        $data = $this->theatreService->getTheatres($zipCode, $radius, $limit, $page);

        // Return the list of theatres as a JSON response
        return response()->json($data);
    }

    // Method to get the list of opening movies
    public function getOpeningMovies()
    {
        // Get the list of opening movies from the TheatreService
        $data = $this->theatreService->getOpeningMovies();

        // Return the list of opening movies as a JSON response
        return response()->json($data);
    }
}
