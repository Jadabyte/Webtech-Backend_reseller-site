<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __($product->title) }}
        </h2>
    </x-slot>

    <main class="m-4 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif
        <div class="d-flex flex-column mt-3">
            <h3 class="text-lg mb-2">Product Images:</h3>
            <div class="d-flex flex-wrap">
            @foreach($productImages as $image)
                <div class="bg-image pt-20 pb-20 pr-20 pl-20 mr-3 mb-3 " style="background-image: url('/storage/{{ $image->product_image_path }}'); background-size: cover; background-position: center;"></div>
            @endforeach
            </div>
        </div>

        <div class="d-flex flex-column">
            <h3 class="text-lg mb-2">Description:</h3>
            <p>{{ $product->description }}</p>
        </div>

        <div class="d-flex flex-column mt-3">
            <h3 class="text-lg mb-2">Price:</h3>
            <p>€ {{ $product->price }}</p>
        </div>
    </main>

</x-app-layout>