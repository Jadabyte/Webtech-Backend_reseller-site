<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chat') }}
        </h2>
    </x-slot>

    <main class="m-4 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif
        <div class="flex justify-content-between">
            <div class="w-50">
                <h3 class="text-xl pb-1 mb-4 w-50" style="border-bottom: 2px solid #3490DC;">Buying</h3>
                <div class="w-50 pb-4">
                    @foreach($buyingChats as $chat)
                    <a href="/chat/{{ $chat->product_id }}/{{ $chat->user_id }}/thread" class="mt-4 p-4 bg-white overflow-hidden shadow-sm sm:rounded-lg d-block cursor-pointer">
                        <div>
                            <div class="mb-2">
                                <h3>{{ $chat->title }}</h3>
                                <h3>Posted by: {{ $chat->name }}</h3>
                            </div>
                            <div>
                                <p>"{{ $chat->message }}"</p>
                                <p>{{ App\Http\Controllers\UserController::friendlyDateTime($chat->created_at) }}</p>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            <div class="w-50 d-flex flex-column align-items-end">
                <h3 class="text-xl pb-1 w-50 text-right" style="border-bottom: 2px solid #3490DC;">Selling</h3>
                <div class="w-50 pb-4">
                    @foreach($sellingChats as $chat)
                    <a href="/chat/{{ $chat->product_id }}/{{ $chat->user_id }}/thread" class="mt-4 p-4 bg-white overflow-hidden shadow-sm sm:rounded-lg d-block cursor-pointer">
                        <div>
                            <div class="mb-2">
                                <h3>{{ $chat->title }}</h3>
                                <h3>Posted by: {{ $chat->name }}</h3>
                            </div>
                            <div>
                                <p>{{ $chat->message }}</p>
                                <p>{{ App\Http\Controllers\UserController::friendlyDateTime($chat->created_at) }}</p>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </main>

</x-app-layout>