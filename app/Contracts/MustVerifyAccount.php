<?php

namespace App\Contracts;

interface MustVerifyAccount
{
    /**
     * Verifica si la cuenta del usuario ha sido verificada.
     */
    public function hasVerifiedAccount(): bool;

    /**
     * Marca la cuenta del usuario como verificada.
     */
    public function markAccountAsVerified(): bool;

    /**
     * Envía la notificación de verificación de la cuenta.
     */
    public function sendAccountVerificationNotification(): void;
}
