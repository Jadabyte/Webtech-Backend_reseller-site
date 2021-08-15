<link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/" class="w-25 m-auto">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Name')" class="d-none" />

                <x-input placeholder="Name" id="name" class="block mt-1 w-full p-2" type="text" name="name" :value="old('name')" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" class="d-none" />

                <x-input placeholder="Email" id="email" class="block mt-1 w-full p-2" type="email" name="email" :value="old('email')" required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" class="d-none" />

                <x-input id="password" class="block mt-1 w-full p-2"
                                type="password"
                                name="password"
                                placeholder="Password"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" class="d-none" />

                <x-input id="password_confirmation" class="block mt-1 w-full p-2"
                                type="password"
                                placeholder="Confirm Password"
                                name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="text-center ml-4 text-dark">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
