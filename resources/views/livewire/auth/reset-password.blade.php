{{-- resources\views\livewire\auth\reset-password.blade.php --}}

<div class="flex flex-col items-center justify-center min-h-screen px-6 py-8 mx-auto lg:py-0">
    <x-app-logo href="/" class="mb-6" imageClass="w-8 h-8 mr-2"
        textClass="text-2xl font-semibold dark:text-white" />

    <x-card variant="auth">
        <x-heading as="h1" variant="auth" class="mb-1">
            {{ __('Reset password') }} 🔑
        </x-heading>

        <form class="mt-4 space-y-4 lg:mt-5 md:space-y-5" wire:submit="resetPassword">
            <x-input wire:model.blur="email" type="email" name="email" id="email" label="{{ __('Email') }}"
                placeholder="{{ __('Enter your email') }}" :state="$errors->has('email') ? 'error' : null" required autocomplete="username"
                disabled />

            <x-input-password wire:model.blur="password" name="password" id="password" label="{{ __('New password') }}"
                placeholder="{{ __('Enter your new password') }}" :state="$errors->has('password') ? 'error' : null" required
                autocomplete="new-password" />

            <x-input-password wire:model.blur="password_confirmation" name="password_confirmation" id="confirm-password"
                label="{{ __('Confirm your new password') }}" placeholder="{{ __('Confirm your new password') }}"
                :state="$errors->has('password') ? 'error' : null" required autocomplete="new-password" />

            <x-button type="submit" wireTarget="resetPassword" class="w-full">
                <x-slot:loading>
                    {{ __('Resetting password...') }}
                </x-slot:loading>
                {{ __('Reset password') }}
            </x-button>
        </form>
    </x-card>
</div>
