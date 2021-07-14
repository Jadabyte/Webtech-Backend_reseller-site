<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __($product->title) }}
        </h2>
    </x-slot>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="d-flex flex-column mt-3">
            <h3 class="text-lg mb-2">Product Images:</h3>
            <div class="d-flex flex-wrap">
            @foreach($productImages as $image)
                <img class="w-25 mr-3 mb-3" src="/storage/{{ $image->product_image_path }}" alt="">
            @endforeach
            </div>
        </div>

        <div class="d-flex flex-column mt-3">
            <h3 class="text-lg mb-2">Description</h3>
            <p>{{ $product->description }}</p>
        </div>

        <div class="d-flex flex-column mt-3">
            <h3 class="text-lg mb-2">Price</h3>
            <p>€ {{ $product->price }}</p>
        </div>
    </main>

</x-app-layout>