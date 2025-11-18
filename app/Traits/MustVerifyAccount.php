<?php

namespace App\Traits;

use App\Enums\OtpPurpose;
use App\Notifications\VerifyAccount;
use App\Services\OtpService;

trait MustVerifyAccount
{
    /**
     * Verifica si la cuenta ha sido verificada.
     */
    public function hasVerifiedAccount(): bool
    {
        return !is_null($this->email_verified_at);
    }

    /**
     * Marca la cuenta como verificada.
     */
    public function markAccountAsVerified(): bool
    {
        return $this->forceFill([
            'email_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    /**
     * Envía la notificación para verificar la cuenta.
     */
    public function sendAccountVerificationNotification(): void
    {
        $otpService = app(OtpService::class);
        $otp = $otpService->generate($this, OtpPurpose::EmailVerification);
        $this->notify(new VerifyAccount($otp));
    }
}
