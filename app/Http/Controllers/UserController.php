<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\NewPasswordController;
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

        return view('profile.show', compact('user', 'userProducts'));
    }

    public static function friendlyDate($rawDate){
        $dateArray = explode("-", substr($rawDate, 0, -9));
        $dateArray = array_reverse($dateArray);

        $friendlyDate = ($dateArray[0] . "/" . $dateArray[1] . "/" . $dateArray[2]);

        return $friendlyDate;
    }

    public function showEditProfile(){
        $user = User::find(Auth::id());

        return view('profile.edit', compact('user'));
    }

    public function editProfile(Request $request){
        $user = User::find(Auth::id());

        $user->name = $request->name;

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
