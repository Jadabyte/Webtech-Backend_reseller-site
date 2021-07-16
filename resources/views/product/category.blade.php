<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __(request()->route('category')) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 d-flex flex-wrap justify-content-center">
            @foreach($products as $product)
            <div class="w-25 m-4 bg-white overflow-hidden shadow-sm sm:rounded-lg" style="background-image: url('/storage/{{ $product->product_thumbnail }}'); background-size: cover; background-position: center;">
                <div class="pt-40 border-b border-gray-200">
                    <p class="bg-white rounded-top d-inline p-3 pt-2">€ {{ $product->price }}</p>
                    <div class="bg-white p-4 pt-3 pb-3">
                        <a href="/product/{{ $product->product_id }}"><h3 class="text-lg text-truncate">{{ $product->title }}</h3></a>
                        <div class="pl-2">
                            <p>Category: <a href="/{{ $product->category_name }}">{{ $product->category_name }}</a></p>
                            <p>Posted by: <a href="/profile/{{ $product->user_id }}">{{ $product->name }}</a></p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
