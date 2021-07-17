<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create a new listing') }}
        </h2>
    </x-slot>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-10">
        <!-- Validation Errors -->
        <x-auth-validation-errors class="m-4 alert alert-danger" :errors="$errors" />

        <form action="/product/create" method="POST" enctype="multipart/form-data" class="d-flex">
            @csrf
            <div class="w-75">
                <div class="d-flex flex-wrap">
                    <div class="d-flex flex-column w-25 mt-3 mr-10">
                        <label for="title" class="text-lg mb-2">1. Title<span class="text-danger"> *</span></label>
                        <input value="{{ old('title') }}" class="p-2" type="text" name="title" placeholder="Give your listing a title" />
                    </div>

                    <div class="d-flex flex-column w-25 mt-3 ml-10">
                        <label for="price" class="text-lg mb-2">2. Price<span class="text-danger"> *</span></label>
                        <div>
                            <span class="text-lg mb-2">€</span>
                            <input value="{{ old('price') }}" name="price" class="w-25 p-2" type="number" min="1" step="any" placeholder="0.0" />
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-column w-25 mt-3">
                    <label for="image" class="text-lg mb-2">3. Add some images<span class="text-danger"> *</span></label>
                    <input value="{{ old('product_img') }}" type="file" name="product_img[]" id="product_img" multiple>
                </div>
                <div class="d-flex flex-wrap">
                    <div class="d-flex flex-column mt-3 w-50 pr-10">
                        <label for="description" class="text-lg mb-2">4. Description<span class="text-danger"> *</span></label>
                        <textarea class="p-2" name="description" id="description" placeholder="Describe what you are selling." cols="30" rows="10">{{ old('description') }}</textarea>
                    </div>

                    <div class="d-flex flex-column mt-3 w-50">
                        <h3 class="text-lg mb-2">5. Select a category for your listing<span class="text-danger"> *</span></h3>
                        @foreach($allCategories as $category)
                            <label for="{{ $loop->index+1 }}">
                                <input type="radio" name="category" id="{{ $loop->index+1 }}" value="{{ $loop->index+1 }}" {{ (old('category') == $loop->index+1) ? 'checked' : ''}}>
                                {{ $category }}
                            </label>
                        @endforeach
                    </div>
                </div>
                <div class="mt-3">
                    <h3 class="text-lg mb-2">6. Location</h3>
                    <div class="d-flex flex-column w-25 r-10">
                        <label class="text-lg mb-2" for="postCode">Postal Code<span class="text-danger"> *</span></label>
                        <input class="p-2" value="{{ $address[0] }}" type="text" name="postCode" id="postCode" placeholder="Enter your postal code">
                    </div>
                    <div class="d-flex flex-column w-25 mt-3 mr-10">
                        <label class="text-lg mb-2" for="country">Country<span class="text-danger"> *</span></label>
                        <input class="p-2" value="{{ $address[3] }}" type="text" name="country" id="country" placeholder="Enter your country">
                    </div>
                </div>
            </div>
            <div class="text-right mt-10 w-25">
                <input class="btn btn-primary text-white text-lg" type="submit" value="Post Listing">
            </div>
        </form>
    </main>
</x-app-layout>

<script>
    $( document ).ready(function(){
        
    });
</script>