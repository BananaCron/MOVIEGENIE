<?php

namespace App\Http\Controllers;

use App\Services\StreamingService;
use Illuminate\Http\Request;

class StreamingController extends Controller
{
    protected $streamingService;

    // Constructor to inject StreamingService dependency
    public function __construct(StreamingService $streamingService)
    {
        $this->streamingService = $streamingService;
    }

    // Method to get streaming availability for a given title
    public function getStreamingAvailability(Request $request)
    {
        // Get the title from the request
        $title = $request->input('title');
        
        // Get the streaming availability data from the StreamingService
        $data = $this->streamingService->getStreamingAvailability($title);
        
        // Return the streaming availability data as a JSON response
        return response()->json($data);
    }

    // Method to get available countries for a given country code
    public function getAvailableCountries(Request $request)
    {
        // Get the country code from the query parameters
        $countryCode = $request->query('countryCode');
        
        // Check if country code parameter is provided
        if ($countryCode) {
            // Get the available countries from the StreamingService
            $data = $this->streamingService->getAvailableCountries($countryCode);
            
            // Return the available countries as a JSON response
            return response()->json($data);
        } else {
            // Return an error response if country code is not provided
            return response()->json(['error' => 'Country code is required'], 400);
        }
    }
}
