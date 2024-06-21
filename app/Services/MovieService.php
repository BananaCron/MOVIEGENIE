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
            'x-rapidapi-host' => 'movies-api14.p.rapidapi.com',
        ];
    }

    public function getMovies()
    {
        try {
            $response = $this->client->request('GET', 'https://movies-api14.p.rapidapi.com/home', [
                'headers' => $this->headers,
            ]);

            $data = json_decode($response->getBody(), true);

            // Check if the response contains data
            if (empty($data)) {
                throw new \Exception('Empty response from API');
            }

            return $data;
        } catch (\Exception $e) {
            // Handle and log the exception
            \Log::error('Error fetching movies: ' . $e->getMessage());
            return []; // Return empty array or handle as needed
        }
    }

    public function getMoviesByTitle($title)
    {
        try {
            $response = $this->client->request('GET', 'https://movies-api14.p.rapidapi.com/search', [
                'headers' => $this->headers,
                'query' => [
                    'query' => $title,
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            // Check if the response contains data
            if (empty($data)) {
                throw new \Exception('Empty response from API');
            }

            return $data;
        } catch (\Exception $e) {
            // Handle and log the exception
            \Log::error('Error fetching movies by title: ' . $e->getMessage());
            return []; // Return empty array or handle as needed
        }
    }
}
