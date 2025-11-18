<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use App\Actions\Auth\ResetUserPassword;
use Illuminate\Validation\Rules\Password;

#[Layout('layouts.guest')]
#[Title('Restablecer contraseña')]
class ResetPassword extends Component
{
    public ?string $email = null;

    #[Validate]
    public string $password = '';

    public string $password_confirmation = '';

    public function rules(): array
    {
        return [
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }

    public function mount(): void
    {
        if (!session()->has('email_for_final_reset')) {
            $this->redirect(route('login'));
            return;
        }
        $this->email = session('email_for_final_reset');
    }

    public function updatedPasswordConfirmation(): void
    {
        $this->validateOnly('password');
    }

    public function resetPassword(ResetUserPassword $resetUserPassword): void
    {
        $validated = $this->validate();

        $resetUserPassword($this->email, $validated['password']);

        session()->forget('email_for_final_reset');
        session()->flash('status', '¡Tu contraseña ha sido restablecida con éxito!');
        $this->redirect(route('login'));
    }

    public function render()
    {
        return view('livewire.auth.reset-password');
    }
}
