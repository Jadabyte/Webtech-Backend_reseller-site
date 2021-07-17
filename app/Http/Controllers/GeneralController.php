<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImages;
use Illuminate\Support\Facades\DB;

class GeneralController extends Controller
{
    public function showHome(){
        $products = Product::join('product_categories','product_categories.id', '=', 'products.product_category_id')
            ->join('users', 'products.user_id', 'users.id')
            ->where('products.active', 1)
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
            ]);
        return view('dashboard', compact('products'));
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

}
