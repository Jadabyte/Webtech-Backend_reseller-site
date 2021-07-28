<?php

namespace App\Http\Controllers;

use App\Models\Messages;
use App\Models\Product;
use App\Models\User;
use App\Mail\ReplyReceived;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ChatController extends Controller
{
    public function showChats(){
        $buyingChats = Messages::where('messages.user_id', Auth::id())
            ->join('products', 'products.id', 'messages.product_id')
            ->join('users', 'users.id', 'products.user_id')
            ->orderBy('created_at', 'desc')
            ->where('products.active', 1)
            ->get([
                'messages.product_id',
                'messages.user_id',
                'messages.message',
                'messages.created_at',
                'users.name',
                'products.title',
            ]);
        //only return most recent message in a conversation
        $productId = null;
        $buyingChatsFirstMessage = [];
        foreach($buyingChats as $chat){
            if($productId != $chat->product_id){
                $productId = $chat->product_id;

                array_push($buyingChatsFirstMessage, $chat);
            }
        }
        $buyingChats = $buyingChatsFirstMessage;

        $sellingChats = Messages::join('products', 'products.id', 'messages.product_id')
            ->join('users', 'users.id', 'products.user_id')
            ->orderBy('created_at', 'desc')
            ->where('products.user_id', Auth::id())
            ->where('products.active', 1)
            ->get([
                'messages.product_id',
                'messages.user_id',
                'messages.message',
                'messages.created_at',
                'users.name',
                'products.title',
            ]);

        
        $productId = null;
        $sellingChatsFirstMessage = [];
        foreach($sellingChats as $chat){
            if($productId != $chat->product_id){
                $productId = $chat->product_id;

                array_push($sellingChatsFirstMessage, $chat);
            }
        }
        $sellingChats = $sellingChatsFirstMessage;

        return view('chat.show', compact('buyingChats', 'sellingChats'));
    }

    public function showThread($productId, $userId){
        $product = Product::where('products.id', $productId)
        ->join('users', 'products.user_id', 'users.id')
        ->first([
            'products.title',
            'users.name',
            'products.id as product_id',
            'users.id as user_id',
        ]);

        $messages = Messages::join('products', 'products.id', 'messages.product_id')
            ->where('messages.user_id', Auth::id())
            ->orWhere('products.user_id', Auth::id())
            ->where('messages.product_id', $productId)
            ->where('messages.user_id', $userId)
            ->get();

        return view('chat.thread', compact('product', 'messages'));
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
                'products.id as product_id',
            ]);
        
        return view('chat.new', compact('product'));
    }

    public function sendMessage(Request $request, $productId){
        $message = new Messages;

        $chatExists = Messages::join('products', 'messages.product_id', 'products.id')
            ->where('messages.product_id', $productId)
            ->where(function ($query) {
                $query->where('messages.user_id', Auth::id())
                      ->orWhere('products.user_id', Auth::id());
            })
            ->first([
                'messages.user_id as message_user_id',
                'products.user_id as product_user_id',
                'messages.product_id',
            ]);
        
        
        $details = [
            'userId' => Auth::id(),
            'userName' => Auth::user()->name,
            'productId' => $productId,
            'productName' => Product::find($productId)->title,
            'body' => $request->message,
        ];

        if($chatExists){
            $message->user_id = $chatExists->message_user_id;

            if($chatExists->product_user_id == Auth::id()){
                $message->product_owner = true;

                Mail::to(User::find($chatExists->message_user_id)->email)
                    ->send(new ReplyReceived($details));
            }

            else{
                Mail::to(User::find($chatExists->product_user_id)->email)
                ->send(new ReplyReceived($details));
            }
        }
        else{
            $message->user_id = Auth::id();

            $userEmail = Product::join('users', 'users.id', 'products.user_id')
                ->where('products.id', $productId)
                ->first();

            Mail::to($userEmail->email)
                ->send(new ReplyReceived($details));
        }


        $message->product_id = $productId;
        $message->message = $request->message;

        $message->save();
        return response()->json(['status', 1]);
    }
}
