<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function showCreate(){
        $categories = ProductCategory::get();

        $allCategories = [];
        foreach($categories as $category){
            array_push($allCategories, $category['name']);
        }
        //if you use the IDs in the view, remember to +1 since an array starts at 0, while the database ID starts at 1
        return view('product.create', compact('allCategories'));
    }
}
