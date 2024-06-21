<?php

namespace App\Http\Controllers;

use App\Services\TheatreService;
use Illuminate\Http\Request;

class TheatreController extends Controller
{
    protected $theatreService;

    public function __construct(TheatreService $theatreService)
    {
        $this->theatreService = $theatreService;
    }

    public function getTheatres(Request $request)
    {
        $zipCode = $request->input('zipCode');
        $radius = $request->input('radius');
        $limit = $request->input('limit', 20);
        $page = $request->input('page', 1);

        if (!$zipCode || !$radius) {
            return response()->json(['error' => 'zipCode and radius are required'], 400);
        }

        $data = $this->theatreService->getTheatres($zipCode, $radius, $limit, $page);
        return response()->json($data);
    }


    public function getOpeningMovies()
    {
        $data = $this->theatreService->getOpeningMovies();
        return response()->json($data);
    }
}
