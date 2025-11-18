<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Http\Request;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use App\Actions\Auth\AuthenticateUser;

#[Layout('layouts.guest')]
#[Title('Iniciar sesión')]
class Login extends Component
{
    #[Validate('required|email|exists:users,email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    #[Validate('boolean')]
    public bool $remember = false;

    public function login(AuthenticateUser $authenticateUser, Request $request): void
    {
        $validated = $this->validate();

        $authenticateUser($validated, $request->ip());
        
        $request->session()->regenerate();
        
        $this->redirectIntended(route('dashboard'), navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
