<?php

namespace App\Actions\Auth;

use App\Models\User;
use App\Enums\OtpPurpose;
use App\Services\OtpService;
use App\Notifications\ResetPassword;
use App\Notifications\VerifyAccount;

class ResendVerificationCode
{
    public function __construct(protected OtpService $otpService)
    {
    }

    public function __invoke(string $email, OtpPurpose $purpose): void
    {
        $user = User::firstWhere('email', $email);

        $otp = $this->otpService->generate($user, $purpose);

        match ($purpose) {
            OtpPurpose::EmailVerification => $user->notify(new VerifyAccount($otp)),
            OtpPurpose::PasswordReset => $user->notify(new ResetPassword($otp)),
        };
    }
}
