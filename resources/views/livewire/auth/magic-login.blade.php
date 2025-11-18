{{-- resources/views/livewire/auth/magic-login.blade.php --}}

<div class="flex flex-col items-center justify-center min-h-screen px-6 py-8 mx-auto lg:py-0">
    <x-app-logo href="/" class="mb-6" imageClass="w-8 h-8 mr-2"
        textClass="text-2xl font-semibold dark:text-white" />

    <x-card variant="auth">
        <x-heading as="h1" variant="auth" class="mb-1">
            {{ __('Magic link') }} 🔐
        </x-heading>

        <x-paragraph class="font-light">
            {{ __('Enter your email to receive a magic link and sign in without a password.') }}
        </x-paragraph>

        @if (session('status'))
            <x-alert color="success" class="my-4">
                {{ session('status') }}
            </x-alert>
        @endif

        <form class="mt-4 space-y-4 lg:mt-5 md:space-y-5" wire:submit="sendMagicLink">
            <x-input wire:model.blur="email" type="email" name="email" id="email" label="{{ __('Email') }}"
                placeholder="{{ __('Enter your email') }}" :state="$errors->has('email') ? 'error' : null" required />

            <x-button type="submit" wireTarget="sendMagicLink" class="w-full">
                <x-slot:loading>
                    {{ __('Sending...') }}
                </x-slot:loading>
                {{ __('Send magic link') }}
            </x-button>
        </form>

        @if (Route::has('login'))
            <div class="mt-5 text-center text-sm">
                <x-link href="{{ route('login') }}">
                    <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12M3 12l7.5-7.5M3 12h18" />
                    </svg>
                    {{ __('Login with password') }}
                </x-link>
            </div>
        @endif
    </x-card>
</div>
