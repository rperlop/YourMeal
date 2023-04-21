<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Utils {

    /**
     * Get a city/town name from latitude and longitude
     *
     * @param number $lat
     * @param number $long
     *
     * @return array|null
     * @throws GuzzleException
     */
    public function getCityName( $lat, $long ): ?string {
        $apiKey   = 'a82c53d8a743452e9323753bab52a057';
        $client   = new Client();
        $url      = "https://api.opencagedata.com/geocode/v1/json?q=" . urlencode( $lat . ',' . $long ) . "&key=" . $apiKey . "&language=en&pretty=1";
        $response = $client->request( 'GET', $url );
        $body     = json_decode( $response->getBody() );

        if ( $body->total_results > 0 ) {
            return $body->results[0]->components->city ?? null;
        } else if ($body->results[0]->components->city == null) {
            return $body->results[0]->components->town ?? null;
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
    public function getLatLong( string $location ): ?array {
        $apiKey   = 'a82c53d8a743452e9323753bab52a057';
        $client   = new Client();
        $url      = "https://api.opencagedata.com/geocode/v1/json?q=" . urlencode( $location ) . "&key=" . $apiKey . "&language=en&pretty=1";
        $response = $client->request( 'GET', $url );
        $body     = json_decode( $response->getBody() );
        if ( $body->total_results > 0 ) {
            $latitude  = $body->results[0]->geometry->lat;
            $longitude = $body->results[0]->geometry->lng;

            return [ 'latitude' => $latitude, 'longitude' => $longitude ];
        } else {
            return null;
        }
    }

}
