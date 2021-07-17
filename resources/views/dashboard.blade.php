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
                <div class="w-25 m-4 bg-white overflow-hidden shadow-sm sm:rounded-lg" style="background-image: url('/storage/{{ $product->product_thumbnail }}'); background-size: cover; background-position: center;">
                    <div class="pt-40 border-b border-gray-200">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="bg-white rounded-top d-inline p-3 pt-2 pb-2">€ {{ $product->price }}</p>
                            <div class="bg-white p-2 rounded-top like cursor-pointer" data-product_id="{{ $product->product_id }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="product-{{ $product->product_id }} bi bi-heart" viewBox="0 0 16 16">
                                    <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/>
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="product-{{ $product->product_id }} bi bi-heart-fill d-none" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/>
                                </svg>
                            </div>
                        </div>
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
    </div>
</x-app-layout>
<script>
    $( document ).ready(function(){
        $('.like').on('click', function(e){
            var productId = $(this).data('product_id');
            $.ajax({
                type: "GET",
                url: '/favorite/' + productId,
                data: {productId: productId},
                success: function(data){
                    $('.product-' + productId).toggleClass('d-none');
                },
            });
        })
    });
</script>
