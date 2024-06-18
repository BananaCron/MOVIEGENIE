<?php

namespace App\Services;

use GuzzleHttp\Client;

class MovieService
{
    protected $client;
    protected $headers;

    public function __construct()
    {
        $this->client = new Client();
        $this->headers = [
            'x-rapidapi-key' => env('RAPIDAPI_KEY'),
            'x-rapidapi-host' => '', // Will be set per API
        ];
    }

    public function getMovies()
    {
        $response = $this->client->request('GET', 'https://moviedatabase8.p.rapidapi.com/Search/Incep', [
            'headers' => [
                'x-rapidapi-key' => env('RAPIDAPI_KEY'),
                'x-rapidapi-host' => 'moviedatabase8.p.rapidapi.com',
            ],
            'query' => [
                's' => 'Batman', // Example query to search for movies
                'r' => 'json'
            ]
        ]);

        return json_decode($response->getBody(), true);
    }


    public function getStreamingAvailability($imdbId)
    {

        $response = $this->client->request('GET', 'https://streaming-availability.p.rapidapi.com/shows/search/title?series_granularity=show&show_type=movie&output_language=en', [
            'headers' => [
                'x-rapidapi-key' => env('RAPIDAPI_KEY'),
                'x-rapidapi-host' => 'streaming-availability.p.rapidapi.com'
            ],
            'query' => [
                'country' => 'US', // Example country code
                'title' => $imdbId
            ]
    ]);

        return json_decode($response->getBody(), true);
    }


    public function getTheatres()
    {
        $response = $this->client->request('GET', 'https://flixster.p.rapidapi.com/theaters/list?zipCode=90002&radius=50', [
            'headers' => [
                'x-rapidapi-key' => env('RAPIDAPI_KEY'),
                'x-rapidapi-host' => 'flixster.p.rapidapi.com',
            ],
            'query' => [
                'limit' => '20', // adjust limit as needed
                'page' => '1'
            ]
    ]);

        return json_decode($response->getBody(), true);
    }

}
