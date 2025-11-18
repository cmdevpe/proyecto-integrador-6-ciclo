<?php

namespace App\Enums;

enum OtpPurpose: string
{
    case EmailVerification = 'email_verification';
    case PasswordReset = 'password_reset';
    case TwoFactorAuth = 'two_factor_authentication';
}
