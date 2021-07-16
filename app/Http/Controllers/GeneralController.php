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
        $products = Product::join('product_images', 'product_images.product_id', '=', 'products.id')
            ->join('product_categories','product_categories.id', '=', 'products.product_category_id')
            ->join('users', 'products.user_id', 'users.id')
            ->get([
                'users.id as user_id',
                'users.name',
                'users.user_avatar_path',
                'products.id as product_id',
                'products.title',
                'products.description',
                'products.price',
                'product_categories.name as category_name', // use 'as [column name]' when selecting columns
                'product_images.product_image_path',        // with the same name
                'products.created_at',
            ]);
        return view('dashboard', compact('products'));
    }

    public function searchProducts(Request $request){
        $products = Product::search($request->search)->get();
        dd($products);
    }

    public function showResults(){

    }

}
