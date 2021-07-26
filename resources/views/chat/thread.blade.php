<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chat history with ' . $product->name . ' about their listing: ' . $product->title) }}
        </h2>
    </x-slot>

    <main class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 d-flex flex-column align-items-center">
            @if(session()->has('message'))
                <div class="alert alert-success w-100">
                    {{ session()->get('message') }}
                </div>
            @endif
            <div class="w-100 m-4 bg-white overflow-hidden shadow-sm sm:rounded-lg" style="background-image: url('/storage/{{ $product->product_thumbnail }}'); background-size: cover; background-position: center;">
                <div id="messages" class="w-100 pr-20 pl-20 m-auto mt-4 text-white d-flex flex-column" style="overflow: auto; height: 500px">
                    @foreach($messages as $message)
                        <!--this one shows on the selling page-->
                        @if($product->user_id == Auth::id())
                            @if($message->product_owner)
                                <div class="w-50 text-right align-self-end ">
                                    <p class="text-black pb-1">{{ App\Http\Controllers\UserController::friendlyDateTime($message->created_at) }}</p>
                                    <div class="text-right bg-primary mw-50 p-4 mb-2 d-inline-block" style="border-radius: 30px 30px 10px 30px">
                                        <p>{{ $message->message }}</p>
                                    </div>
                                </div>
                            @else
                                <div class="w-100">
                                    <p class="text-black pb-1">{{ App\Http\Controllers\UserController::friendlyDateTime($message->created_at) }}</p>
                                    <div class="text-left bg-secondary mw-50 p-4 align-self-start mb-2 d-inline-block" style="border-radius: 30px 30px 30px 10px">
                                        <p>{{ $message->message }}</p>
                                    </div>
                                </div>
                            @endif
                            
                        <!--this one shows on the buying page-->
                        @else
                            @if($message->product_owner)
                                <div class="w-100">
                                    <p class="text-black pb-1">{{ App\Http\Controllers\UserController::friendlyDateTime($message->created_at) }}</p>
                                    <div class="text-left bg-secondary mw-50 p-4 align-self-start mb-2 d-inline-block" style="border-radius: 30px 30px 30px 10px">
                                        <p>{{ $message->message }}</p>
                                    </div>
                                </div>
                            @else
                                <div class="w-50 text-right align-self-end ">
                                    <p class="text-black pb-1">{{ App\Http\Controllers\UserController::friendlyDateTime($message->created_at) }}</p>
                                    <div class="text-right bg-primary mw-50 p-4 mb-2 d-inline-block" style="border-radius: 30px 30px 10px 30px">
                                        <p>{{ $message->message }}</p>
                                    </div>
                                </div>
                            @endif
                        @endif
                    @endforeach
                </div>
                <div class="p-4 pt-0 w-100 d-flex align-items-center justify-content-center" method="post" action="/chat/{{ $product->product_id }}/new">
                    @csrf
                    <input class="w-75 p-2 m-4 mb-2" type="text" name="message" id="message" placeholder="Send a reply" autofocus>
                    <button id="send" data-product_id="{{ $product->product_id }}" data-user_id="{{ $product->user_id }}" class="m-4 mb-2 btn btn-primary text-white" type="submit">Send message</button>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>

<script>
    $( document ).ready(function(){
        $('#messages').animate({
            scrollTop: $('#messages').get(0).scrollHeight
        }, 0);

        $('#send').on('click', function(e){
            var productId = $(this).data('product_id');
            var userId = $(this).data('user_id');
            var message = $('#message').val();
            
            $.ajax({
                type: "GET",
                url: '/chat/' + productId + '/' + userId,
                data: {message: message},
                success: function(data){
                    $('#messages').append('<div class="text-right bg-primary p-4 mw-50 align-self-end mb-4" style="border-radius: 30px 30px 10px 30px"><p>' + message + '</p></div>');
                    $('#message').val('');
                    
                    $('#messages').animate({
                        scrollTop: $('#messages').get(0).scrollHeight
                    }, 0);
                },
            });
        })
    });
</script>