{{-- resources/views/errors/500.blade.php --}}

<x-guest-layout>
    <x-slot:title>
        {{ __('Server Error') }}
    </x-slot:title>

    <div class="flex flex-col justify-center items-center px-6 mx-auto h-screen xl:px-0">
        <div class="w-full max-w-sm mb-8">
            <img class="w-full h-auto" src="https://flowbite-admin-dashboard.vercel.app/images/illustrations/500.svg"
                alt="Ilustración de Error de Servidor 500">
        </div>

        <div class="text-center xl:max-w-4xl">
            <h1 class="mb-3 text-2xl font-bold leading-tight text-gray-900 sm:text-4xl lg:text-5xl dark:text-white">
                {{ __('Server Error') }}
            </h1>

            <p class="mb-5 text-base font-normal text-gray-500 md:text-lg dark:text-gray-400">
                {{ __('Oops! Something went wrong on our end. We\'re already working to fix it as soon as possible.') }}
            </p>

            <x-button href="{{ route('dashboard') }}" wire:navigate>
                <svg class="mr-2 -ml-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                        clip-rule="evenodd"></path>
                </svg>
                {{ __('Go back home') }}
            </x-button>
        </div>
    </div>
</x-guest-layout>
