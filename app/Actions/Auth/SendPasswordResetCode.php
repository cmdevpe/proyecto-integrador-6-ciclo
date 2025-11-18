<?php

namespace App\Actions\Auth;

use App\Models\User;
use App\Enums\OtpPurpose;
use App\Services\OtpService;
use App\Notifications\ResetPassword;

class SendPasswordResetCode
{

    public function __construct(protected OtpService $otpService)
    {
    }

    public function __invoke(string $email): void
    {
        $user = User::firstWhere('email', $email);
        $otp = $this->otpService->generate($user, OtpPurpose::PasswordReset);
        $user->notify(new ResetPassword($otp));
    }
}
