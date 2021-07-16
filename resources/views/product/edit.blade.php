<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editing: "' . $product->title . '"') }}
        </h2>
    </x-slot>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Validation Errors -->
        <x-auth-validation-errors class="m-4 alert alert-danger" :errors="$errors" />
        @if(session()->has('message'))
            <div class="alert alert-success m-4 d-flex justify-content-between">
                {{ session()->get('message') }}
                <a class="underline" href="/product/{{ $product->product_id }}">Return to Listing</a>
            </div>
        @endif

        <form action="/product/{{ $product->product_id }}/edit" method="POST" enctype="multipart/form-data" class="d-flex">
            @csrf
            <div class="w-75">
                <div class="d-flex flex-wrap">
                    <div class="d-flex flex-column w-25 mt-3 mr-10">
                        <label for="title" class="text-lg mb-2">1. Title</label>
                        <input value="{{ $product->title }}" class="p-2" type="text" name="title" placeholder="Give your listing a title" />
                    </div>

                    <div class="d-flex flex-column w-25 mt-3 ml-10">
                        <label for="price" class="text-lg mb-2">2. Price</label>
                        <div>
                            <span class="text-lg mb-2">€</span>
                            <input value="{{ $product->price }}" name="price" class="w-25 p-2" type="number" min="1" step="any" placeholder="0.0" />
                        </div>
                    </div>
                </div>
                <div>
                    <div class="d-flex flex-column w-full mt-3">
                        <label for="image" class="text-lg mb-2">3. Photos</label>
                        <div class="d-flex flex-wrap w-full">
                            @foreach($productImages as $image)
                                <div class="bg-image w-20 h-20 pt-20 pb-20 pr-20 pl-20 rounded mr-3 mb-3 d-inline" 
                                    style="background-image: url('/storage/{{ $image->product_image_path }}'); 
                                            background-size: cover; 
                                            background-position: center;">
                                </div>
                            @endforeach
                        </div>
                        <input value="{{ old('product_img') }}" type="file" name="product_img[]" id="product_img" multiple>
                    </div>
                    <div class="d-flex align-items-center">
                        <input type="checkbox" name="removeImages" id="removeImages">
                        <label for="removeImages" class="ml-2">Remove existing images?</label>
                    </div>
                </div>
                <div class="d-flex flex-wrap mb-10">
                    <div class="d-flex flex-column mt-3 w-50 pr-10">
                        <label for="description" class="text-lg mb-2">4. Description</label>
                        <textarea class="p-2" name="description" id="description" placeholder="Describe what you are selling." cols="30" rows="9">{{ $product->description }}</textarea>
                    </div>

                    <div class="d-flex flex-column mt-3 w-50">
                        <h3 class="text-lg mb-2">5. Select a category for your listing</h3>
                        @foreach($allCategories as $category)
                            <label for="{{ $loop->index+1 }}">
                                <input type="radio" name="category" id="{{ $loop->index+1 }}" value="{{ $loop->index+1 }}" {{ ($product->category_id == $loop->index+1) ? 'checked' : ''}}>
                                {{ $category }}
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="text-right mt-10 w-25">
                <input class="btn btn-primary text-white text-lg w-75" type="submit" value="Save Changes">
                <a class="btn btn-secondary text-lg mt-2 w-75" type="button" href="/product/{{ $product->product_id }}">Return to Listing</a>
            </div>
        </form>
    </main>
</x-app-layout>

<script>
    $( document ).ready(function(){
        
    });
</script>