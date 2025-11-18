<?php

namespace App\Actions\Auth;

use Illuminate\Support\Str;
use App\Traits\WithThrottling;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticateUser
{
    use WithThrottling;

    public function __invoke(array $credentials, string $ipAddress): void
    {
        $throttleKey = Str::transliterate(Str::lower($credentials['email']) . '|' . $ipAddress);

        $this->throttle(key: $throttleKey, maxAttempts: 5, errorField: 'email');

        if (
            !Auth::attempt(
                ['email' => $credentials['email'], 'password' => $credentials['password']],
                $credentials['remember'] ?? false
            )
        ) {
            $this->hit($throttleKey);

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        $this->clear($throttleKey);
    }
}
