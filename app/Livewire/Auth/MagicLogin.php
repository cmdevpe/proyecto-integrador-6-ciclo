<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Traits\WithThrottling;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use App\Actions\Auth\SendMagicLink;

#[Layout('layouts.guest')]
#[Title('Enlace mágico')]
class MagicLogin extends Component
{
    use WithThrottling;

    #[Validate('required|email|exists:users,email')]
    public string $email = '';

    public function sendMagicLink(SendMagicLink $sendMagicLink): void
    {
        $validated = $this->validate();
        $email = $validated['email'];

        $throttleKey = $this->getEmailThrottleKey($email);

        $this->throttle(key: $throttleKey, maxAttempts: 1, errorField: 'email');

        $sendMagicLink($email);

        $this->hit(key: $throttleKey, decaySeconds: 60);

        session()->flash('status', __('We have sent you a magic link to your email.'));
        $this->reset('email');
    }

    public function render()
    {
        return view('livewire.auth.magic-login');
    }
}
