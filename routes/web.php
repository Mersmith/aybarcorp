<?php

use App\Http\Controllers\Web\LoginController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

Route::middleware('redirect.by.role')->group(function () {
    Route::get('/', [LoginController::class, 'indexIngresarCliente'])->name('home');
});
