<?php

use App\Http\Controllers\Web\LoginController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

Route::get('/', [LoginController::class, 'indexIngresarCliente'])->name('home');
