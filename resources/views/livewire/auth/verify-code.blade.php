{{-- resources\views\livewire\auth\verify-email.blade.php --}}

<div class="flex flex-col items-center justify-center min-h-screen px-6 py-8 mx-auto lg:py-0">
    <x-app-logo href="/" class="mb-6" imageClass="w-8 h-8 mr-2"
        textClass="text-2xl font-semibold dark:text-white" />

    <x-card variant="auth">
        <x-heading as="h1" variant="auth" class="mb-1">
            {{ __('Verify code') }} 🔐
        </x-heading>

        <x-paragraph class="font-light">
            {{ __('We have sent a 6-digit code to your email.') }}
        </x-paragraph>

        @if (session('status'))
            <x-alert color="success" class="my-4">
                {{ session('status') }}
            </x-alert>
        @endif

        <form class="mt-4 space-y-4 lg:mt-5 md:space-y-5" wire:submit="verify">
            <x-otp-input label="{{ __('Verification code') }}" name="code" call="verify" />

            <x-button type="submit" wireTarget="verify" class="w-full">
                <x-slot:loading>
                    {{ __('Verifying...') }}
                </x-slot:loading>
                {{ __('Verify code') }}
            </x-button>

            <x-paragraph variant="boxed" class="mt-6">
                {{ __("Haven't received the code yet?") }}
                <x-button wire:click="resend" link>{{ __('Forward') }}</x-button>
                @if (session()->has('email_for_verification'))
                    {{ __('or') }}
                    <x-button wire:click="logout" link>{{ __('Log Out') }}</x-button>
                @endif
            </x-paragraph>
        </form>
    </x-card>
</div>
