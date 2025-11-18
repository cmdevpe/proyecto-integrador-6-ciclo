<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Events\AccountCreated;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use App\Actions\Auth\RegisterUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

#[Layout('layouts.guest')]
#[Title('Crear cuenta')]
class Register extends Component
{
    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|string|email|max:255|unique:users,email')]
    public string $email = '';

    #[Validate]
    public string $password = '';

    public string $password_confirmation = '';

    protected function rules()
    {
        return [
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }

    public function updatedPasswordConfirmation(): void
    {
        $this->validateOnly('password');
    }

    public function register(RegisterUser $registerUser): void
    {
        $validated = $this->validate();

        $user = $registerUser($validated);

        event(new AccountCreated($user));

        Auth::login($user);

        $this->redirect(route('dashboard'), navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
