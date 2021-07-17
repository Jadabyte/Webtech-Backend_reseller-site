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

        $latitude = $result['position']['lat'];
        $longitude = $result['position']['lng'];
        $latLong = [
            'lat' => $latitude, 
            'lng' => $longitude];

        return [$latLong];
    }
}
