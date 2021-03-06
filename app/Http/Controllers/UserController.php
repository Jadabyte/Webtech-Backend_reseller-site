<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\HEREController;
use App\Models\User;
use App\Models\Product;
use App\Traits\UploadTrait;

class UserController extends Controller
{
    use UploadTrait;

    public function showProfile($id){
        $user = User::find($id);

        $userProducts = Product::join('product_categories','product_categories.id', '=', 'products.product_category_id')
            ->join('users', 'products.user_id', 'users.id')
            ->where('products.user_id', $id)
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
                'products.product_thumbnail',                // with the same name
                'products.created_at',
            ]);

        $address = explode("+", $user['address']);

        return view('profile.show', compact('user', 'userProducts', 'address'));
    }

    public static function friendlyDate($rawDate){
        $dateArray = explode("-", substr($rawDate, 0, -9));
        $dateArray = array_reverse($dateArray);

        $friendlyDate = ($dateArray[0] . "/" . $dateArray[1] . "/" . $dateArray[2]);

        return $friendlyDate;
    }

    public static function friendlyDateTime($rawDate){
        $dateArray = explode("-", substr($rawDate, 0, -9));
        $dateArray = array_reverse($dateArray);

        $time = substr($rawDate, 11, -3);

        $friendlyDateTime = ($dateArray[0] . "/" . $dateArray[1] . "/" . $dateArray[2]) . " - " . $time;

        return $friendlyDateTime;
    }

    public function showEditProfile(){
        $user = User::find(Auth::id());
        $address = explode("+", $user['address']);

        return view('profile.edit', compact('user', 'address'));
    }

    public function editProfile(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'postCode' => 'required',
            'country' => 'required',
        ]);
        
        if(filesize($request->avatar) > 2000000){
            session()->flash("error","Your profile image may not exceed 2mb");
            return back();
        }

        $user = User::find(Auth::id());

        try {
            $location = (new HEREController)->searchByAddress($request->postCode, $request->country);
            $latLng = $location['coordinates'];
    
            $user->name = $request->name;
            $user->lat = $latLng['lat'];
            $user->lng = $latLng['lng'];
            $user->address = implode("+", $location['address']);
        } catch (\Throwable $th) {
            session()->flash("error","Please enter a valid postal code and country");
            return redirect('/profile/edit');
        }

        if (($request->avatar) != null) {
            $image = $request->file('avatar');
            $name = $request->input('name').'_'.time();
            $nameCheck1 = preg_replace('/[^a-zA-Z0-9\']/', '_', $name);
            $nameCheck2 = str_replace("'", '', $nameCheck1);
            $name = str_replace(' ', '_', $nameCheck2);

            $folder = 'user-avatars/';
            $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();

            //this comes from /Traits/UploadTrait
            $this->uploadOne($image, $folder, 'public', $name);

            $user->user_avatar_path = $filePath;
        }

        $user->save();

        session()->flash("message","Changes saved");
        return redirect('/profile/edit');
    }
}
