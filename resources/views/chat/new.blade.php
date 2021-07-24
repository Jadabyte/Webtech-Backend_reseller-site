<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Send a message to ' . $product->name . ' about their listing: ' . $product->title) }}
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
                <form class="p-4 pt-0 w-100" method="post" action="/chat/{{ $product->product_id }}/new">
                    @csrf
                    <div class="pt-0">
                        <label for="message"></label>
                        <textarea class="w-100 p-2" name="message" id="" rows="10" placeholder="Write a message"></textarea>
                    </div>
                    <div class="text-right">
                        <button class="m-4 mb-2 btn btn-primary text-white" type="submit">Send message</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</x-app-layout>