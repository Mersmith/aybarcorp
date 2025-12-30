<?php

use App\Http\Controllers\Cliente\InicioController;
use App\Http\Controllers\Cliente\DireccionController;
use App\Http\Controllers\Cliente\LoteController;
use Illuminate\Support\Facades\Route;

Route::get('/home', [InicioController::class, 'index'])->name('home');

Route::get('/lote', [LoteController::class, 'index'])->name('lote');
