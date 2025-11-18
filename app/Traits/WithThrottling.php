<?php

namespace App\Traits;

use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

trait WithThrottling
{
    /**
     * Verifica el límite de peticiones y lanza una excepción si se excede.
     */
    public function throttle(string $key, int $maxAttempts, string $errorField = 'email'): void
    {
        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);

            throw ValidationException::withMessages([
                $errorField => trans('auth.throttle', [
                    'seconds' => $seconds,
                    'minutes' => ceil($seconds / 60),
                ]),
            ]);
        }
    }

    /**
     * Registra un intento y activa el cooldown.
     */
    public function hit(string $key, int $decaySeconds = 60): void
    {
        RateLimiter::hit($key, $decaySeconds);
    }

    /**
     * Resetea el contador de intentos para una clave.
     */
    public function clear(string $key): void
    {
        RateLimiter::clear($key);
    }

    /**
     * Crea una clave de throttle estándar para email y IP.
     */
    protected function getEmailThrottleKey(string $email): string
    {
        return Str::transliterate(Str::lower($email) . '|' . request()->ip());
    }
}
