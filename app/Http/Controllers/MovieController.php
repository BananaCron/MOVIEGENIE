<?php

namespace App\Http\Controllers;

use App\Services\MovieService;

class MovieController extends Controller
{
    protected $movieService;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    public function getMovies()
    {
        $data = $this->movieService->getMovies();
        return response()->json($data);
    }

    public function getStreamingAvailability($imdbId)
    {
        $data = $this->movieService->getStreamingAvailability($imdbId);
        return response()->json($data);
    }

    public function getTheatres()
    {
        $data = $this->movieService->getTheatres();
        return response()->json($data);
    }
}
