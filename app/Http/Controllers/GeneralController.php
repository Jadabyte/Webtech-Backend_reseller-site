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
        $products = Product::get();

        /*foreach($products as $product){
            $productImg = ProductImages::where('product_id', $product['id'])->first();
            $productCategory = ProductCategory::find($product['product_category_id']);

            $productDetails = array_push($product['0'], $productImg['product_image_path']);
            //dd($productDetails);
        }*/
        return view('dashboard');
    }

}
