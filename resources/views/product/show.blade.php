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
        @if($product->user_id == Auth::id())
            <div class="pb-2 d-flex align-items-center justify-content-end border-bottom">
                <a class="ml-2 btn btn-primary text-white" href="/product/{{ $product->product_id }}/edit">Edit listing</a>
                <form action="/product/{{ $product->product_id }}/remove" method="post">
                    @csrf
                    <input class="ml-2 btn btn-danger text-white" type="submit" value="Remove listing">
                </form>
            </div>
        @else
            <div class="pb-2 d-flex align-items-center justify-content-end border-bottom">
                <a class="ml-2 btn btn-primary text-white" href="/chat/{{ $product->product_id }}">Message product owner</a>
            </div>
        @endif
        <div class="d-flex justify-content-center w-full">
            <div class="text-center mt-4 pr-5 border-end d-flex flex-column align-items-center">
                <h2 class="mb-2 text-xl">Posted by:</h2>
                <a href="/profile/{{ $user->id }}">
                    <div class="bg-image mb-2 w-20 h-20 pt-20 pb-20 pr-20 pl-20 rounded-circle" 
                        style="background-image: url('/storage/{{ $user->user_avatar_path }}'); 
                                background-size: cover; 
                                background-position: center;">
                    </div>
                    <div class="mb-2">
                        <h3 class="text-lg">{{ $user->name }}</h3>
                    </div>
                </a>
                <div class="mb-2">
                    <h3 class="underline text-lg">Location:</h3>
                    <p>{{ $address[1] }}, {{ $address[3] }}</p>
                </div>
            </div>
            <div class="m-4 mt-2 w-full">
                <div class="d-flex flex-column mt-3">
                    <h3 class="text-lg mb-2">Product Images:</h3>
                    <div class="d-flex flex-wrap">
                    @foreach($productImages as $image)
                        <div class="bg-image pt-20 pb-20 pr-20 pl-20 rounded mr-3 mb-3" style="background-image: url('/storage/{{ $image->product_image_path }}'); background-size: cover; background-position: center;"></div>
                    @endforeach
                    </div>
                </div>

                <div class="d-flex flex-column">
                    <h3 class="text-lg mb-2">Category:</h3>
                    <p>{{ $product->category_name }}</p>
                </div>

                <div class="d-flex flex-column mt-3">
                    <h3 class="text-lg mb-2">Description:</h3>
                    <p>{{ $product->description }}</p>
                </div>

                <div class="d-flex flex-column mt-3">
                    <h3 class="text-lg mb-2">Price:</h3>
                    <p>€ {{ $product->price }}</p>
                </div>
            </div>
        </div>
    </main>

</x-app-layout>