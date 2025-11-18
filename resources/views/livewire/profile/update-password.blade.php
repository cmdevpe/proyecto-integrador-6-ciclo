<x-card variant="profile">
    <x-heading as="h3" variant="subtitle" class="mb-4">
        {{ __('Change password') }}
    </x-heading>

    <form wire:submit="updatePassword">
        <div class="grid grid-cols-6 gap-6">
            <input type="email" name="username" value="{{ auth()->user()->email }}" style="display: none;"
                autocomplete="username">

            <div class="col-span-6 sm:col-span-3">
                <x-input-password wire:model.blur="current_password" name="current_password" id="current_password"
                    label="{{ __('Current password') }}" placeholder="{{ __('Enter your current password') }}"
                    :state="$errors->has('current_password') ? 'error' : null" required autocomplete="current-password" />
            </div>

            <div class="col-span-6 sm:col-span-3">
                <x-input-password wire:model.blur="password" name="password" id="password"
                    label="{{ __('New password') }}" placeholder="{{ __('Enter your new password') }}" :state="$errors->has('password') ? 'error' : null"
                    required autocomplete="new-password" />
            </div>

            <div class="col-span-6 sm:col-span-3">
                <x-input-password wire:model.blur="password_confirmation" name="password_confirmation"
                    id="password_confirmation" label="{{ __('Confirm your new password') }}"
                    placeholder="{{ __('Confirm your new password') }}" :state="$errors->has('password') ? 'error' : null" required
                    autocomplete="new-password" />
            </div>

            <div class="col-span-6 sm:col-full">
                <x-button type="submit" wireTarget="updatePassword">
                    <x-slot:loading>
                        {{ __('Updating...') }}
                    </x-slot:loading>
                    {{ __('Update password') }}
                </x-button>
            </div>
        </div>
    </form>
</x-card>
