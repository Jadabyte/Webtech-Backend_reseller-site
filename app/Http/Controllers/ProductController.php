<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\ProductImages;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Traits\UploadTrait;
use App\Http\Controllers\HEREController;

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
        $product = Product::join('product_categories','product_categories.id', '=', 'products.product_category_id')
        ->join('users', 'products.user_id', 'users.id')
        ->where('products.id', $id)
        ->first([
            'users.id as user_id',
            'users.name',
            'users.user_avatar_path',
            'products.id as product_id',
            'products.title',
            'products.description',
            'products.price',
            'product_categories.name as category_name',
            'products.created_at',
            'products.address',
        ]);

        $user = User::select(['address', 'user_avatar_path', 'name', 'created_at', 'id'])
            ->find($product['user_id']);
        
        $address = explode("+", $product['address']);

        $productImages = ProductImages::where('product_id', $id)
            ->where('active', 1)
            ->get('product_image_path');

        return view('product.show', compact('product', 'productImages', 'user', 'address'));
    }

    public function showEditProduct($id){
        $product = Product::join('product_categories','product_categories.id', '=', 'products.product_category_id')
        ->join('users', 'products.user_id', 'users.id')
        ->where('products.id', $id)
        ->first([
            'users.id as user_id',
            'users.name',
            'users.user_avatar_path',
            'products.id as product_id',
            'products.title',
            'products.description',
            'products.price',
            'product_categories.id as category_id',
            'products.created_at',
        ]);
        
        $categories = ProductCategory::get();

        $allCategories = [];
        foreach($categories as $category){
            array_push($allCategories, $category['name']);
        }

        $productImages = ProductImages::where('product_id', $id)
            ->where('active', 1)
            ->get('product_image_path');

        return view('product.edit', compact('product', 'productImages', 'allCategories'));
    }

    public function editProduct(Request $request, $id){
        $product = Product::find($id);
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required',
        ]);

        $product->product_category_id = $request->category;
        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;

        if (($request->product_img) != null) {
            if($request->removeImages == 'on'){
                ProductImages::where('active', '1')
                    ->where('product_id', $id)
                    ->update(['active' => 0]);
            }

            foreach($request->file('product_img') as $index => $image){
                $productImage = new ProductImages;

                $productImage->product_id = $id;
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

                if($index == 1){
                    $setThumbnail = Product::find($id);
                    $setThumbnail->product_thumbnail = $filePath;
                    $setThumbnail->save();
                }
            }
        }

        $product->save();
        session()->flash("message","Changes saved");
        return redirect('/product/' . $id . '/edit');
    }

    public function createProduct(Request $request){
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required',
        ]);

        //-Create a new product----------
        $location = (new HEREController)->searchByAddress($request->postCode, $request->country);
        $latLng = $location['coordinates'];

        $product = new Product;

        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;

        $product->user_id = Auth::id();
        $product->product_category_id = $request->category;
        $product->lat = $latLng['lat'];
        $product->lng = $latLng['lng'];
        $product->address = implode("+", $location['address']);

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

                if($index == 1){
                    $setThumbnail = Product::find($productId);
                    $setThumbnail->product_thumbnail = $filePath;
                    $setThumbnail->save();
                }
            }
        }

        return redirect('/product/' . $productId)->with('message', 'Your listing was created successfully');
    }

    public function removeProduct($id){
        $product = Product::find($id);
        $product->active = 0;
        $product->save();

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
            
        session()->flash("message","Listing removed");
        return view('/dashboard', compact('products'));
    }

    public function showCategory($category){
        $products = Product::join('product_categories','product_categories.id', '=', 'products.product_category_id')
            ->join('users', 'products.user_id', 'users.id')
            ->where('product_categories.name', $category)
            ->where('products.active', 1)
            ->get([
                'users.id as user_id',
                'users.name',
                'users.user_avatar_path',
                'products.id as product_id',
                'products.title',
                'products.price',
                'products.description',
                'product_categories.name as category_name', // use 'as [column name]' when selecting columns
                'products.product_thumbnail',        // with the same name
                'products.created_at',
            ]);
        return view('product.category', compact('products'));
    }

    public static function getCategories(){
        $categories = ProductCategory::get();

        return $categories;
    }
}
