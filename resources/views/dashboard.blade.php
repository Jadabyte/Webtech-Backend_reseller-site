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
                                @if(App\Http\Controllers\GeneralController::checkFavorite($product->product_id) == 1)
                                    <img src="/img/heart-fill.svg" class="product-{{ $product->product_id }} h-5 w-5" alt="Favorite product">
                                    <img src="/img/heart.svg" class="product-{{ $product->product_id }} h-5 w-5 d-none" alt="Favorite product">
                                @else
                                    <img src="/img/heart-fill.svg" class="product-{{ $product->product_id }} h-5 w-5 d-none" alt="Favorite product">
                                    <img src="/img/heart.svg" class="product-{{ $product->product_id }} h-5 w-5" alt="Favorite product">
                                @endif
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
