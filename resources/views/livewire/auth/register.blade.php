{{-- resources\views\livewire\auth\register.blade.php --}}

<div class="flex flex-col items-center justify-center min-h-screen px-6 py-8 mx-auto lg:py-0">
    <x-app-logo href="/" class="mb-6" imageClass="w-8 h-8 mr-2"
        textClass="text-2xl font-semibold dark:text-white" />

    <x-card variant="auth">
        <x-heading as="h1" variant="auth" class="mb-1">
            {{ __('Create new account') }} ✨
        </x-heading>

        <form class="mt-4 space-y-4 lg:mt-5 md:space-y-5" wire:submit="register">
            <x-input wire:model.blur="name" type="text" name="name" id="name" label="{{ __('Full name') }}"
                placeholder="{{ __('Enter your full name') }}" :state="$errors->has('name') ? 'error' : null" required autocomplete="name" />

            <x-input wire:model.blur="email" type="email" name="email" id="email" label="{{ __('Email') }}"
                placeholder="{{ __('Enter your email') }}" :state="$errors->has('email') ? 'error' : null" required autocomplete="username" />

            <x-input-password wire:model.blur="password" name="password" id="password" label="{{ __('Password') }}"
                placeholder="{{ __('Enter your password') }}" :state="$errors->has('password') ? 'error' : null" required autocomplete="new-password" />

            <x-input-password wire:model.blur="password_confirmation" name="password_confirmation"
                id="password_confirmation" label="{{ __('Confirm password') }}"
                placeholder="{{ __('Enter the password again') }}" :state="$errors->has('password') ? 'error' : null" required
                autocomplete="new-password" />

            <x-button type="submit" wireTarget="register" class="w-full">
                <x-slot:loading>
                    {{ __('Signing up...') }}
                </x-slot:loading>
                {{ __('Sign up') }}
            </x-button>

            @if (Route::has('login'))
                <x-paragraph class="text-sm font-light">
                    {{ __('Already have an account?') }}
                    <x-link href="{{ route('login') }}"> {{ __('Sign in here') }}</x-link>
                </x-paragraph>
            @endif
        </form>
    </x-card>
</div>
