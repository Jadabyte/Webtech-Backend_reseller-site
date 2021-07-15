<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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
        $user->save();

        session()->flash("message","Changes saved");
        return redirect('/profile/edit');
    }
}
