<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UpdatePassword extends Component
{
    #[Validate]
    public string $current_password = '';

    #[Validate]
    public string $password = '';

    public string $password_confirmation = '';

    protected function rules()
    {
        return [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'different:current_password', Password::defaults()],
        ];
    }

    public function updatedPasswordConfirmation(): void
    {
        $this->validateOnly('password');
    }

    public function updatePassword()
    {
        $this->validate();

        auth()->user()->update([
            'password' => Hash::make($this->password),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('toast', type: 'success', message: __('Password successfully updated.'));
    }

    public function render()
    {
        return view('livewire.profile.update-password');
    }
}
