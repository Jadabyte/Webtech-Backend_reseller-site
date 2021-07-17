<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImages;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class GeneralController extends Controller
{
    public function showHome(){
        $products = Product::join('product_categories','product_categories.id', '=', 'products.product_category_id')
            ->join('users', 'products.user_id', 'users.id')
            ->where('products.active', 1)
            ->orderBy('created_at', 'desc')
            ->get([
                'users.id as user_id',
                'users.name',
                'users.user_avatar_path',
                'products.id as product_id',
                'products.title',
                'products.description',
                'products.price',
                'product_categories.name as category_name', // use 'as [column name]' when selecting columns
                'products.product_thumbnail',               // with the same name
                'products.created_at',
                'products.lat',
                'products.lng',
            ]);

        $user = Auth::user();

        if($user['lat']){
            $userLat = $user['lat'];
            $userLng = $user['lng'];
    
    
            $resultsFilteredByDistance = [];
            foreach($products as $product){
                $productLat = $product['lat'];
                $productLng = $product['lng'];
                
                $distanceMeters = GeneralController::haversineGreatCircleDistance($userLat, $userLng, $productLat, $productLng);
                $distanceKilometers = round($distanceMeters/1000);
    
                if($distanceKilometers < 10){
                    array_push($resultsFilteredByDistance, $product);
                }
            }
            $products = $resultsFilteredByDistance;
            $address = explode("+", $user['address'])[1];
        }
        else{
            $address = null;
        }

        return view('dashboard', compact('products', 'address'));
    }

    public function showResults(Request $request){
        $searchInput = $request->search;
        $products = Product::search(request('search'))
            ->where('active', 1)
            ->get();

        $productResults = [];
        foreach($products as $product){
            $productDetails = Product::join('product_categories','product_categories.id', '=', 'products.product_category_id')
            ->join('users', 'products.user_id', 'users.id')
            ->where('products.id', $product['id'])
            ->first([
                'users.id as user_id',
                'users.name',
                'users.user_avatar_path',
                'products.id as product_id',
                'products.title',
                'products.description',
                'products.price',
                'product_categories.name as category_name', // use 'as [column name]' when selecting columns
                'products.product_thumbnail',        // with the same name
                'products.created_at',
            ]);

            array_push($productResults, $productDetails);
        }

        return view('search', compact('productResults', 'searchInput'));
    }

    /** Retrieved from: https://stackoverflow.com/a/14751773
     * Calculates the great-circle distance between two points, with
     * the Haversine formula.
     * @param float $latitudeFrom Latitude of start point in [deg decimal]
     * @param float $longitudeFrom Longitude of start point in [deg decimal]
     * @param float $latitudeTo Latitude of target point in [deg decimal]
     * @param float $longitudeTo Longitude of target point in [deg decimal]
     * @param float $earthRadius Mean earth radius in [m]
     * @return float Distance between points in [m] (same as earthRadius)
     */
    function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000){
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);
    
        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;
    
        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
        cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

        return $angle * $earthRadius;
    }

}
