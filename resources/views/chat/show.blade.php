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
        <div class="flex border rounded bg-info">
            <div class="bg-primary w-25 pb-4">
            @foreach($chats as $chat)
                <div class="p-4 pb-0">
                    <div class="pb-2">
                        <h3>{{ $chat->title }}</h3>
                        <h3>Posted by: {{ $chat->name }}</h3>
                    </div>
                    <div>
                        <p>{{ $chat->message }}</p>
                        <p>{{ App\Http\Controllers\UserController::friendlyDateTime($chat->created_at) }}</p>
                    </div>
                </div>
            @endforeach
            </div>
            <div class="bg-secondary w-75 d-flex flex-column p-4">
                <div id="messages" class="h-100">
                    <p>Message</p>
                </div>
                <form action="/chat/{{ $chat->product_id }}/{{ $chat->user_id }}" method="post" class="align-self-baseline w-100">
                    @csrf
                    <input type="text" name="message" placeholder="Send a message">
                    <button type="submit">Send</button>
                </form>
            </div>
        </div>
    </main>

</x-app-layout>