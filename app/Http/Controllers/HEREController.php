<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HEREController extends Controller
{
    public function searchByAddress($postCode, $country){
        $apiKey = '&apiKey=' . config('services.here.token');
        $address = $postCode . '+' . $country;

        $addressResults = Http::get('https://geocode.search.hereapi.com/v1/geocode?q=' . $address . $apiKey)
            ->json(['items']);
        
        $result = $addressResults[0];

        $address = $result['address']['label'];
        $addressItems = explode(", ", $address);

        $latitude = $result['position']['lat'];
        $longitude = $result['position']['lng'];

        $location = [
            'coordinates' => 
                ['lat' => $latitude, 
                'lng' => $longitude],
            'address' =>
                ['postCode' => $addressItems[0],
                'city' => $addressItems[1],
                'county' => $addressItems[2],
                'country' => $addressItems[3]]    
            ];
        return $location;
    }

    public function searchByCoordinates($lat, $long){
        $apiKey = '&apiKey=' . config('services.here.token');

        $coordinates = $lat . '%2C' . $lng;

        $coordinateResults = Http::get('https://geocode.search.hereapi.com/v1/revgeocode?at=' . $coordinates . $apiKey)
            ->json(['items']);
        $coordinateResults = $coordinateResults[0];

        dd($coordinateResults);
    }
}
