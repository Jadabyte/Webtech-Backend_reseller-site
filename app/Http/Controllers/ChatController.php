<?php

namespace App\Http\Controllers;

use App\Models\Messages;
use App\Models\Product;
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
                'messages.user_id',
                'messages.message',
                'messages.created_at',
                'users.name',
                'products.title',
            ]);

        return view('chat.show', compact('chats'));
    }

    public function createChatShow($productId){
        // 1. Users will be able to create a new chat using a button on the product page
        // 2. User enters a message and a new chat with relevant info is created in db
        // 3. Product owner receives an email notifying them of the message
        // 4. They can reply to the message on the Messages page - all necessary info is passed in the url (product_id, user_id)

        // (5.) Two different pages for buying and selling
        $product = Product::where('products.id', $productId)
            ->join('users', 'products.user_id', 'users.id')
            ->first([
                'products.title',
                'users.name',
                'products.id as product_id'
            ]);
        
        return view('chat.new', compact('product'));
    }

    public function sendMessage(Request $request, $productId){
        $message = new Messages;

        $chatExists = Messages::where('product_id', $productId)
            ->where('user_id', Auth::id())
            ->first();

        if($chatExists){
            $message->user_id = $chatExists('user_id');
        }
        else{
            $message->user_id = Auth::id();
        }

        $message->product_id = $productId;
        $message->message = $request->message;

        $message->save();
        session()->flash("message","Your message has been sent, you will be notified when the product owner sends a reply.");
        return redirect('/chat/' . $productId . '/new');
    }
}
