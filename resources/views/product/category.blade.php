<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __(request()->route('category')) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 d-flex flex-wrap justify-content-center">
            @if(empty($products[0]))
                <p class="alert alert-info m-4 mt-0">There are currently no listings in the {{ request()->route('category') }} category, <a class="underline" href="/dashboard">return home</a>.</p>
            @endif
            @foreach($products as $product)
                @include('components.product')
            @endforeach
        </div>
    </div>
</x-app-layout>
