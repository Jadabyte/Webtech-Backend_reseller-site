<?php

namespace App\Http\Controllers;

use App\Models\Messages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function showChats(){
        $chats = Messages::where('messages.user_id', Auth::id())
            ->join('products', 'products.id', 'messages.product_id')
            ->join('users', 'users.id', 'products.user_id')
            ->get([
                'messages.product_id',
                'messages.message',
                'messages.created_at',
                'users.name',
                'products.title',
            ]);

        return view('chat.show', compact('chats'));
    }
}
