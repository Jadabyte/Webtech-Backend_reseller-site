<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit your profile') }}
        </h2>
    </x-slot>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(session()->has('message'))
            <div class="alert alert-success m-4">
                {{ session()->get('message') }}
            </div>
        @endif
        <x-auth-validation-errors class="m-4 alert alert-danger" :errors="$errors" />
        <form action="/profile/edit" method="POST" enctype="multipart/form-data" class="d-flex">
            @csrf
            <div class="w-75">
                <div class="d-flex flex-column w-25 mt-3">
                    <label for="name" class="text-lg mb-2">Name:</label>
                    <input value="{{ $user->name }}" class="p-2" type="text" name="name" id="name">
                </div>

                <div class="mt-3">
                    <div class="bg-image w-20 h-20 pt-20 pb-20 pr-20 pl-20 rounded-circle" 
                        style="background-image: url('/storage/{{ $user->user_avatar_path }}'); 
                                background-size: cover; 
                                background-position: center;">
                    </div>

                    <div class="d-flex flex-column w-25 mt-3">
                        <label for="image" class="text-lg mb-2">Your Profile Image:</label>
                        <input type="file" name="avatar" id="avatar">
                    </div>
                </div>

                <div class="mt-3">
                    <h3 class="text-lg mb-2">Location:</h3>
                    <div class="d-flex flex-column w-25 r-10">
                        <label class="text-md mb-2" for="postCode">Postal Code</label>
                        <input class="p-2" value="{{ $address[0] ?? '' }}" type="text" name="postCode" id="postCode" placeholder="Enter your postal code">
                    </div>
                    <div class="d-flex flex-column w-25 mt-3 mr-10">
                        <label class="text-md mb-2" for="country">Country</label>
                        <input class="p-2" value="{{ $address[3] ?? '' }}" type="text" name="country" id="country" placeholder="Enter your country">
                    </div>
                </div>
            </div>
            <div class="text-right mt-10 w-25">
                <input class="btn btn-primary text-white text-lg mt-3" type="submit" value="Save Details">
            </div>
        </form>
        <!--
        <form action="profile/changePassword">
            @csrf
            <div class="d-flex flex-column w-25 mt-3">
                <label class="text-lg mb-2" for="password-old">Current password</label>
                <input class="p-2" type="password" name="password-old" id="password-old">
            </div>
            
            <div class="d-flex flex-column w-25 mt-3">
                <label class="text-lg mb-2" for="password-new">New password</label>
                <input class="p-2" type="password" name="password-new" id="password-new">
            </div>

            <div class="d-flex flex-column w-25 mt-3">
                <label class="text-lg mb-2" for="password-repeat">Repeat new password</label>
                <input class="p-2" type="password" name="password-repeat" id="password-repeat">
            </div>

            <input class="btn btn-primary text-white text-lg mt-3" type="submit" value="Set Password">
        </form>
        -->
    </main>

</x-app-layout>