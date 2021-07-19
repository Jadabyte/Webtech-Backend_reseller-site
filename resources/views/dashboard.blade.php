<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if($address != null)
                {{ __('Listings near '. $address) }}
            @else
                {{ __('Recent listings') }}
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session()->has('message'))
                <div class="alert alert-danger m-4">
                    {{ session()->get('message') }}
                </div>
            @endif
            @if($address == null)
                <div class="alert alert-info m-4 mt-0">
                    <a class="underline" href="/profile/edit">Complete your profile</a>
                </div>
            @endif
            
            <div class="d-flex flex-wrap justify-content-center">
                @foreach($products as $product)
                    @include('components.product')
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
