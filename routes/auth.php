<?php

use App\Http\Controllers\Web\LoginController;
use App\Http\Controllers\Web\VerificationController;
use App\Livewire\Web\Sesion\ClienteRegistrarLivewire;
use Illuminate\Support\Facades\Route;

Route::middleware('redirect.by.role')->group(function () {
    Route::get('/ingresar', [LoginController::class, 'indexIngresarCliente'])->name('ingresar.cliente');
    Route::get('/registrar', ClienteRegistrarLivewire::class)->name('registrar.cliente');

    Route::get('/ingresar/admin', [LoginController::class, 'indexIngresarAdmin'])->name('ingresar.admin');
});

Route::post('/ingresar', [LoginController::class, 'ingresarCliente'])->name('ingresar.cliente');
Route::post('/logout', [LoginController::class, 'logoutCliente'])->name('logout.cliente');

Route::post('/ingresar/admin', [LoginController::class, 'ingresarAdmin'])->name('ingresar.admin');
Route::post('/logout/admin', [LoginController::class, 'logoutAdmin'])->name('logout.admin');

Route::post('/email/verification-notification', [VerificationController::class, 'send'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');
