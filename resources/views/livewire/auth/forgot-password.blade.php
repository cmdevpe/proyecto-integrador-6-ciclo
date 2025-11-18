{{-- resources\views\livewire\auth\forgot-password.blade.php --}}

<div class="flex flex-col items-center justify-center min-h-screen px-6 py-8 mx-auto lg:py-0">
    <x-app-logo
    href="/"
    class="mb-6"
    imageClass="w-8 h-8 mr-2"
    textClass="text-2xl font-semibold dark:text-white"
/>

    <x-card variant="auth">
        <x-heading as="h1" variant="auth" class="mb-1">
            {{ __('Forgot your password?') }} 🔒
        </x-heading>

        <x-paragraph class="font-light">
            {{ __("Don't worry! Enter your email and we'll send you a link to reset it.") }}
        </x-paragraph>

        <form class="mt-4 space-y-4 lg:mt-5 md:space-y-5" wire:submit="sendResetCode">
            <x-input wire:model.blur="email" type="email" name="email" id="email" label="{{ __('Email') }}"
                placeholder="{{ __('Enter your email') }}" :state="$errors->has('email') ? 'error' : null" required />

            <x-button type="submit" wireTarget="sendResetCode" class="w-full">
                <x-slot:loading>
                    {{ __('Sending...') }}
                </x-slot:loading>
                {{ __('Send password reset code') }}
            </x-button>
        </form>

        @if (Route::has('login'))
            <div class="mt-5 text-center text-sm">
                <x-link href="{{ route('login') }}">
                    <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12M3 12l7.5-7.5M3 12h18" />
                    </svg>
                    {{ __('Back to login') }}
                </x-link>
            </div>
        @endif
    </x-card>
</div>
