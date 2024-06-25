<?php

namespace App\Services;

use GuzzleHttp\Client;

class MovieService
{
    protected $client;
    protected $headers;

    // Constructor to initialize the HTTP client and headers for the API requests
    public function __construct()
    {
        $this->client = new Client();
        $this->headers = [
            'x-rapidapi-key' => env('RAPIDAPI_KEY'),
            'x-rapidapi-host' => 'movies-api14.p.rapidapi.com',
        ];
    }

    // Method to fetch the list of movies
    public function getMovies()
    {
        try {
            // Make a GET request to the API endpoint
            $response = $this->client->request('GET', 'https://movies-api14.p.rapidapi.com/home', [
                'headers' => $this->headers,
            ]);

            // Decode the response body to an associative array
            $data = json_decode($response->getBody(), true);

            // Check if the response contains data
            if (empty($data)) {
                throw new \Exception('Empty response from API');
            }

            // Return the data
            return $data;
        } catch (\Exception $e) {
            // Handle and log the exception
            \Log::error('Error fetching movies: ' . $e->getMessage());
            return []; // Return empty array or handle as needed
        }
    }

    // Method to fetch movies by title
    public function getMoviesByTitle($title)
    {
        try {
            // Make a GET request to the API endpoint with the title as a query parameter
            $response = $this->client->request('GET', 'https://movies-api14.p.rapidapi.com/search', [
                'headers' => $this->headers,
                'query' => [
                    'query' => $title,
                ],
            ]);

            // Decode the response body to an associative array
            $data = json_decode($response->getBody(), true);

            // Check if the response contains data
            if (empty($data)) {
                throw new \Exception('Empty response from API');
            }

            // Return the data
            return $data;
        } catch (\Exception $e) {
            // Handle and log the exception
            \Log::error('Error fetching movies by title: ' . $e->getMessage());
            return []; // Return empty array or handle as needed
        }
    }
}
