<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __($user->name."'s profile") }}
        </h2>
    </x-slot>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 d-flex justify-content-center">
        <div class="text-center mt-4 pr-5 border-end">
            <h2 class="mb-4 text-xl">User Details:</h2>
            <div class="bg-image mb-4 w-20 h-20 pt-20 pb-20 pr-20 pl-20 rounded-circle" 
                style="background-image: url('/storage/{{ $user->user_avatar_path }}'); 
                        background-size: cover; 
                        background-position: center;">
            </div>
            <h3>Member since: {{ App\Http\Controllers\UserController::friendlyDate($user->created_at) }}</h3>
        </div>
        <div class="w-full">
            <h2 class="m-4 mb-0 text-xl">User Listings:</h2>
            <div class="d-flex flex-wrap">
            @foreach($userProducts as $product)
                <div class="w-25 m-4 bg-white overflow-hidden shadow-sm sm:rounded-lg" style="background-image: url('/storage/{{ $product->product_image_path }}'); background-size: cover; background-position: center;">
                    <div class="pt-40 border-b border-gray-200">
                        <p class="bg-white rounded-top d-inline p-3 pt-2">€ {{ $product->price }}</p>
                        <div class="bg-white p-4 pt-3 pb-3">
                            <a href="/product/{{ $product->product_id }}"><h3 class="text-lg text-truncate">{{ $product->title }}</h3></a>
                            <div class="pl-2">
                                <p>Category: <a href="/{{ $product->category_name }}">{{ $product->category_name }}</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
    </main>
</x-app-layout>
