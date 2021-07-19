<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Your favorited products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="d-flex flex-wrap justify-content-center">
                @if(empty($products[0]))
                    <div class="alert alert-info m-4 mt-0 text-center">
                        <p>You currently do not have any favorites, add some by clicking the heart icon next to a product.</p>
                        <a class="underline" href="/dashboard">return home</a>
                    </div>
                @endif
                @foreach($products as $product)
                    @include('components.product')
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
