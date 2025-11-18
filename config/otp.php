
<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Time To Live (TTL)
    |--------------------------------------------------------------------------
    |
    | Define cuántos segundos será válido un código OTP después de ser generado.
    | Por defecto, 10 minutos (600 segundos).
    |
    */
    'ttl' => 600,

    /*
    |--------------------------------------------------------------------------
    | Max Attempts
    |--------------------------------------------------------------------------
    |
    | Define el número máximo de intentos de verificación fallidos antes de
    | que un código OTP sea bloqueado.
    |
    */
    'max_attempts' => 5,
];
