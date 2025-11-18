<?php

namespace App\Services;

use App\Enums\OtpPurpose;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OtpService
{
    /**
     * Genera, guarda y devuelve un nuevo OTP para un usuario.
     */
    public function generate(User $user, OtpPurpose $purpose): string
    {
        $code = (string) random_int(100000, 999999);
        $ttl = max(600, (int) config('otp.ttl', 600));

        DB::transaction(function () use ($user, $purpose, $code, $ttl) {
            $user->oneTimePasswords()
                ->purpose($purpose)
                ->unconsumed()
                ->update(['expires_at' => now()]);

            $user->oneTimePasswords()->create([
                'purpose' => $purpose->value,
                'code_hash' => Hash::make($code),
                'max_attempts' => (int) config('otp.max_attempts', 5),
                'expires_at' => now()->addSeconds($ttl),
            ]);
        });

        return $code;
    }

    /**
     * Verifica si un código es válido para un usuario y propósito.
     */
    public function verify(User $user, string $code, OtpPurpose $purpose): array
    {
        $otp = $user->oneTimePasswords()
            ->purpose($purpose)
            ->active()
            ->latestFirst()
            ->first();

        if (!$otp) {
            return ['status' => 'error', 'message' => 'El código ha expirado o no es válido.'];
        }

        if ($otp->attempts >= $otp->max_attempts) {
            return ['status' => 'error', 'message' => 'Has superado el número máximo de intentos.'];
        }

        if (!Hash::check($code, $otp->code_hash)) {
            $otp->increment('attempts');
            return ['status' => 'error', 'message' => 'El código proporcionado es incorrecto.'];
        }

        $otp->update(['consumed_at' => now()]);

        return ['status' => 'success', 'message' => 'Código verificado correctamente.'];
    }
}
