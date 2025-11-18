<x-card variant="profile" class="mb-4">
    <x-heading as="h3" variant="subtitle" class="mb-4">
        {{ __('Profile information') }}
    </x-heading>

    <form wire:submit="updateProfile">
        <div class="grid grid-cols-6 gap-6">
            <div class="col-span-6 sm:col-span-3">
                <x-input wire:model.blur="name" name="name" label="{{ __('Full name') }}"
                    placeholder="{{ __('Enter your full name') }}" :state="$errors->has('name') ? 'error' : null" required autocomplete="name" />
            </div>

            <div class="col-span-6 sm:col-span-3">
                <x-input wire:model.blur="email" type="email" name="email" label="{{ __('Email') }}"
                    placeholder="{{ __('Enter your email') }}" :state="$errors->has('email') ? 'error' : null" required autocomplete="email" />
            </div>

            <div class="col-span-6 sm:col-span-3">
                <x-input wire:model.blur="phone" type="tel" name="phone" label="{{ __('Phone number') }}"
                    placeholder="{{ __('Enter your phone number') }}" :state="$errors->has('phone') ? 'error' : null" autocomplete="tel" />
            </div>

            <div class="col-span-6 sm:col-span-3">
                <x-select wire:model.blur="role" name="role" label="{{ __('Role') }}" :state="$errors->has('role') ? 'error' : null">
                    <option selected>{{ __('Select your role') }}</option>
                    <option value="US">United States</option>
                    <option value="CA">Canada</option>
                    <option value="FR">France</option>
                    <option value="DE">Germany</option>
                </x-select>
            </div>

            <div class="col-span-6 sm:col-full">
                <x-button type="submit" wireTarget="updateProfile">
                    <x-slot:loading>
                        {{ __('Saving changes...') }}
                    </x-slot:loading>
                    {{ __('Save changes') }}
                </x-button>
            </div>
        </div>
    </form>
</x-card>
