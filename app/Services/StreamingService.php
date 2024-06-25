<?php

namespace App\Services;

use GuzzleHttp\Client;

class StreamingService
{
    protected $client;
    protected $headers;

    // Constructor to initialize the HTTP client and headers for the API requests
    public function __construct()
    {
        $this->client = new Client();
        $this->headers = [
            'x-rapidapi-key' => env('RAPIDAPI_KEY'),
            'x-rapidapi-host' => 'streaming-availability.p.rapidapi.com',
        ];
    }

    // Method to get streaming availability for a given title
    public function getStreamingAvailability($title = null)
    {
        // Set default query parameters
        $query = [
            'series_granularity' => 'show',
            'show_type' => 'movie',
            'output_language' => 'en',
            'country' => 'US',
        ];

        // If a title is provided, add it to the query parameters
        if ($title) {
            $query['title'] = $title;
        }

        // Make a GET request to the API endpoint with the query parameters
        $response = $this->client->request('GET', 'https://streaming-availability.p.rapidapi.com/shows/search/title', [
            'headers' => $this->headers,
            'query' => $query,
        ]);

        // Decode the response body to an associative array and return it
        return json_decode($response->getBody(), true);
    }

    // Method to get available streaming countries for a given country code
    public function getAvailableCountries($countryCode)
    {
        // Make a GET request to the API endpoint with the country code
        $response = $this->client->request('GET', "https://streaming-availability.p.rapidapi.com/countries/{$countryCode}", [
            'headers' => $this->headers,
        ]);

        // Decode the response body to an associative array and return it
        return json_decode($response->getBody(), true);
    }
}
