<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImages;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Traits\UploadTrait;

class ProductController extends Controller
{
    use UploadTrait;

    public function showCreate(){
        $categories = ProductCategory::get();

        $allCategories = [];
        foreach($categories as $category){
            array_push($allCategories, $category['name']);
        }
        //if you use the IDs in the view, remember to +1 since an array starts at 0, while the database ID starts at 1
        return view('product.create', compact('allCategories'));
    }

    public function showProduct($id){
        $product = Product::where('id', $id)->first();
        $productImages = ProductImages::where('product_id', $id)->get('product_image_path');
        //dd($productImages);
        return view('product.show', compact('product', 'productImages'));
    }

    public function createProduct(Request $request){
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required',
        ]);

        //-Create a new product----------
        $product = new Product;

        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;

        $product->user_id = Auth::id();
        $product->product_category_id = $request->category;

        $product->save();

        //-Get product's id--------------
        $productId = Product::where('description', $request->description)
            ->orderBy('created_at', 'DESC')
            ->first('id');
        $productId = $productId['id'];

        //-Enter product images into db---
        if (($request->product_img) != null) {
            foreach($request->file('product_img') as $index => $image){
                $productImage = new ProductImages;

                $productImage->product_id = $productId;
                $index = $index + 1;
                
                //$image = $request->file('product_img');
                $name = $request->input('title').'_img-'.$index.'_'.time();
                $nameCheck1 = preg_replace('/[^a-zA-Z0-9\']/', '_', $name);
                $nameCheck2 = str_replace("'", '', $nameCheck1);
                $name = str_replace(' ', '_', $nameCheck2);

                $folder = 'product-photos/';

                $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();

                //this comes from /Traits/UploadTrait
                $this->uploadOne($image, $folder, 'public', $name);

                $productImage->product_image_path = $filePath;

                $productImage->save();
            }
        }

        return redirect('/product/' . $productId)->with('message', 'Your listing was created successfully');
    }
}