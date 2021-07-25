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
                <div class="w-75 m-auto mt-4 text-white d-flex flex-column">
                    @foreach($messages as $message)
                        @if($message->product_owner)
                            <div class="text-center bg-primary p-4 w-25 align-self-end mb-4" style="border-radius: 30px 30px 10px 30px">
                                <p>{{ $message->message }}</p>
                            </div>
                        @else
                            <div class="text-center bg-secondary p-4 w-25 mb-4" style="border-radius: 30px 30px 30px 10px">
                                <p>{{ $message->message }}</p>
                            </div>
                        @endif
                    @endforeach
                </div>
                <form class="p-4 pt-0 w-100 d-flex align-items-center justify-content-center" method="post" action="/chat/{{ $product->product_id }}/new">
                    @csrf
                    <input class="w-75 p-2 m-4 mb-2" type="text" name="message" id="message" placeholder="Send a reply">
                    <button class="m-4 mb-2 btn btn-primary text-white" type="submit">Send message</button>
                </form>
            </div>
        </div>
    </main>
</x-app-layout>