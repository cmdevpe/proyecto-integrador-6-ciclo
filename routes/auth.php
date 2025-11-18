<?php

use App\Livewire\Admin\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\MagicLinkController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\MagicLogin;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\ResetPassword;
use App\Livewire\Auth\VerifyCode;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\User;
use App\Livewire\Profile\ProfileShow;

/*
|--------------------------------------------------------------------------
| Rutas de Autenticación
|--------------------------------------------------------------------------
*/

// --- Rutas para Invitados (Usuarios NO autenticados) ---
Route::middleware('guest')->group(function () {
    // Registro
    Route::get('/register', Register::class)->name('register');

    // Inicio de Sesión
    Route::get('/login', Login::class)->name('login');

    // Flujo de recuperación de contraseña
    Route::get('/forgot-password', ForgotPassword::class)->name('password.request');
    Route::get('/verify-password-code', VerifyCode::class)->name('password.verify.code');
    Route::get('/reset-password', ResetPassword::class)->name('password.reset');

    // Autenticación con Magic Link
    Route::get('/login/magic-link', MagicLogin::class)->name('login.magic');
    Route::get('/login/magic-link/verify/{token}', [MagicLinkController::class, 'verify'])->name('login.magic.verify');

    // Autenticación con Redes Sociales (Socialite)
    Route::get('/auth/{provider}/redirect', [SocialiteController::class, 'redirect'])->name('socialite.redirect');
    Route::get('/auth/{provider}/callback', [SocialiteController::class, 'callback'])->name('socialite.callback');
});

// --- Rutas para Usuarios Autenticados ---
Route::middleware('auth')->group(function () {
    // Ruta para la verificación de una cuenta nueva
    Route::get('/verify-account', VerifyCode::class)->name('account.verify');

    // Rutas que requieren que la cuenta SÍ esté verificada
    Route::middleware('account.verified')->group(function () {
        Route::get('/dashboard', Dashboard::class)->name('dashboard');
        Route::get('/usuarios', User::class)->name('users');
        Route::get('/usuarios/perfil', ProfileShow::class)->name('profile.show');

        Route::get('/categorias', Category::class)->name('categories');
    });
});
