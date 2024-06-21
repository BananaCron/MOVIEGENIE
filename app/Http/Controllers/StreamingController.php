<?php

namespace App\Http\Controllers;

use App\Services\StreamingService;
use Illuminate\Http\Request;

class StreamingController extends Controller
{
    protected $streamingService;

    public function __construct(StreamingService $streamingService)
    {
        $this->streamingService = $streamingService;
    }

    public function getStreamingAvailability(Request $request)
    {
        $title = $request->input('title');
        $data = $this->streamingService->getStreamingAvailability($title);
        return response()->json($data);
    }

    public function getAvailableCountries(Request $request)
    {
        $countryCode = $request->query('countryCode');
        if ($countryCode) {
            $data = $this->streamingService->getAvailableCountries($countryCode);
            return response()->json($data);
        } else {
            return response()->json(['error' => 'Country code is required'], 400);
        }
    }
}
