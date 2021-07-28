<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __($user->name."'s profile") }}
        </h2>
    </x-slot>

    <header class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(session()->has('message'))
            <div class="alert alert-danger m-4">
                {{ session()->get('message') }}
            </div>
        @endif
    </header>
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 d-flex justify-content-center">
        <div class="text-center mt-4 pr-5 border-end">
            <h2 class="mb-4 text-xl">User Details:</h2>
            <div class="bg-image mb-2 w-20 h-20 pt-20 pb-20 pr-20 pl-20 rounded-circle" 
                style="background-image: url('/storage/{{ $user->user_avatar_path }}'); 
                        background-size: cover; 
                        background-position: center;">
            </div>
            <div class="mb-2">
                <h3 class="underline text-lg">Location:</h3>
                <p>{{ $address[1] ?? '' }}, {{ $address[3] ?? '' }}</p>
            </div>
            <div class="mb-2">
                <h3 class="underline text-lg">Member since:</h3>
                <p>{{ App\Http\Controllers\UserController::friendlyDate($user->created_at) }}</p>
            </div>
        </div>
        <div class="w-full">
            <h2 class="m-4 mb-0 text-xl">User Listings:</h2>
            <div class="d-flex flex-wrap">
            @if(empty($userProducts[0]))
                <p class="alert alert-info m-4">You currently do not have any listings, <a class="underline" href="/product/create">create one by clicking here</a>.</p>
            @endif
            @foreach($userProducts as $product)
                @include('components.product')
            @endforeach
            </div>
        </div>
    </main>
</x-app-layout>

