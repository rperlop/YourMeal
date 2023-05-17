<?php

namespace App\Libraries;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Utilities {

    /**
     * Get a city/town name from latitude and longitude
     *
     * @param number $lat
     * @param number $long
     *
     * @return array|null
     * @throws GuzzleException
     */
    public function get_full_address($lat, $long): ?string {
        $client = new Client();
        $url = "https://api.opencagedata.com/geocode/v1/json?q=" . urlencode($lat . ',' . $long) . "&key=" . env('OPENCAGE_API_KEY') . "&language=en&pretty=1";
        $response = $client->request('GET', $url);
        $body = json_decode($response->getBody());

        if ($body->total_results > 0) {
            return $body->results[0]->formatted ?? null;
        } else {
            return null;
        }
    }

    /**
     * Get latitude and longitude from a city/town name
     *
     * @param string $location
     *
     * @return array|null
     * @throws GuzzleException
     */
    public function get_lat_long(string $location): ?array {
        $apiKey = env('OPENCAGE_API_KEY');
        $client = new Client();
        $url = "https://api.opencagedata.com/geocode/v1/json?q=" . urlencode($location) . "&key=" . $apiKey . "&language=en&pretty=1";
        $response = $client->request('GET', $url);
        $body = json_decode($response->getBody());

        if ($body->total_results > 0) {
            $latitude = $body->results[0]->geometry->lat;
            $longitude = $body->results[0]->geometry->lng;

            return ['latitude' => $latitude, 'longitude' => $longitude];
        } else {
            return null;
        }
    }

}
