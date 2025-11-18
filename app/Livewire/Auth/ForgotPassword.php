<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Traits\WithThrottling;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use App\Actions\Auth\SendPasswordResetCode;

#[Layout('layouts.guest')]
#[Title('¿Olvidaste tu contraseña?')]
class ForgotPassword extends Component
{
    use WithThrottling;

    #[Validate('required|email|exists:users,email')]
    public string $email = '';

    public function sendResetCode(SendPasswordResetCode $sendPasswordResetCode): void
    {
        $validated = $this->validate();
        $email = $validated['email'];

        $throttleKey = $this->getEmailThrottleKey($email);

        $this->throttle(key: $throttleKey, maxAttempts: 1, errorField: 'email');

        $sendPasswordResetCode($email);

        $this->hit(key: $throttleKey, decaySeconds: 60);

        session(['email_for_password_reset' => $email]);
        session()->flash('status', __('passwords.sent'));
        $this->redirect(route('password.verify.code'), navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.forgot-password');
    }
}
