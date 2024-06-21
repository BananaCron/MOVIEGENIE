<?php

namespace App\Http\Controllers;

use App\Services\MovieService;
use Illuminate\Http\Request;

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

    public function getMoviesByTitle(Request $request)
    {
        $title = $request->input('title');
        if ($title) {
            $data = $this->movieService->getMoviesByTitle($title);
            return response()->json($data);
        } else {
            return response()->json(['error' => 'Title parameter is required'], 400);
        }
    }
}
