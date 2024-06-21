<?php

namespace App\Services;

use GuzzleHttp\Client;

class StreamingService
{
    protected $client;
    protected $headers;

    public function __construct()
    {
        $this->client = new Client();
        $this->headers = [
            'x-rapidapi-key' => env('RAPIDAPI_KEY'),
            'x-rapidapi-host' => 'streaming-availability.p.rapidapi.com',
        ];
    }

    public function getStreamingAvailability($title = null)
    {
        $query = [
            'series_granularity' => 'show',
            'show_type' => 'movie',
            'output_language' => 'en',
            'country' => 'US',
        ];

        if ($title) {
            $query['title'] = $title;
        }

        $response = $this->client->request('GET', 'https://streaming-availability.p.rapidapi.com/shows/search/title', [
            'headers' => $this->headers,
            'query' => $query,
        ]);

        return json_decode($response->getBody(), true);
    }

    public function getAvailableCountries($countryCode)
    {
        $response = $this->client->request('GET', "https://streaming-availability.p.rapidapi.com/countries/{$countryCode}", [
            'headers' => $this->headers,
        ]);

        return json_decode($response->getBody(), true);
    }
}
