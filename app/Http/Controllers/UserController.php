<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Models\User;
use App\Traits\UploadTrait;

class UserController extends Controller
{
    use UploadTrait;

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
