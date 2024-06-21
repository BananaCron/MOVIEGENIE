<?php

namespace App\Services;

use GuzzleHttp\Client;

class TheatreService
{
    protected $client;
    protected $headers;

    public function __construct()
    {
        $this->client = new Client();
        $this->headers = [
            'x-rapidapi-key' => env('RAPIDAPI_KEY'),
            'x-rapidapi-host' => 'flixster.p.rapidapi.com',
        ];
    }

    public function getTheatres($zipCode, $radius, $limit = 20, $page = 1)
    {
        $response = $this->client->request('GET', 'https://flixster.p.rapidapi.com/theaters/list', [
            'headers' => $this->headers,
            'query' => [
                'zipCode' => $zipCode,
                'radius' => $radius,
                'limit' => $limit,
                'page' => $page
            ]
        ]);

        return json_decode($response->getBody(), true);
    }


    public function getOpeningMovies($countryId = 'usa')
    {
        $response = $this->client->request('GET', 'https://flixster.p.rapidapi.com/movies/get-opening', [
            'headers' => $this->headers,
            'query' => [
                'countryId' => $countryId,
                //Country IDs = afg|alb|dza|asm|and|ago|aia|ata|atg|arg|arm|abw|aus|aut|aze|bhs|bhr|bgd|brb|blr|bel|blz|ben|bmu|btn|bol|bes|bih|bwa|bvt|bra|iot|brn|bgr|bfa|bdi|cpv|khm|cmr|can|cym|caf|tcd|chl|chn|cxr|cck|col|com|cod|cog|cok|cri|hrv|cub|cuw|cyp|cze|civ|dnk|dji|dma|dom|ecu|egy|slv|gnq|eri|est|swz|eth|flk|fro|fji|fin|fra|guf|pyf|atf|gab|gmb|geo|deu|gha|gib|grc|grl|grd|glp|gum|gtm|ggy|gin|gnb|guy|hti|hmd|vat|hnd|hkg|hun|isl|ind|idn|irn|irq|irl|imn|isr|ita|jam|jpn|jey|jor|kaz|ken|kir|prk|kor|kwt|kgz|lao|lva|lbn|lso|lbr|lby|lie|ltu|lux|mac|mdg|mwi|mys|mdv|mli|mlt|mhl|mtq|mrt|mus|myt|mex|fsm|mda|mco|mng|mne|msr|mar|moz|mmr|nam|nru|npl|nld|ncl|nzl|nic|ner|nga|niu|nfk|mnp|nor|omn|pak|plw|pse|pan|png|pry|per|phl|pcn|pol|prt|pri|qat|mkd|rou|rus|rwa|reu|blm|shn|kna|lca|maf|spm|vct|wsm|smr|stp|sau|sen|srb|syc|sle|sgp|sxm|svk|svn|slb|som|zaf|sgs|ssd|esp|lka|sdn|sur|sjm|swe|che|syr|twn|tjk|tza|tha|tls|tgo|tkl|ton|tto|tun|tur|tkm|tca|tuv|uga|ukr|are|gbr|umi|usa|ury|uzb|vut|ven|vnm|vgb|vir|wlf|esh|yem|zmb|zwe|ala
            ]
        ]);

        return json_decode($response->getBody(), true);
    }
}
