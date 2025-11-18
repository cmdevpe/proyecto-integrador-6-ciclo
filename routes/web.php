<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



// Rutas de cmdev/auth
require __DIR__.'/auth.php';
