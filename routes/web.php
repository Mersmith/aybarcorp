<?php

use App\Http\Controllers\Web\LoginController;
use App\Http\Controllers\Web\ConsultaCodigoClienteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CavaliController;
use App\Http\Controllers\SlinController;

require __DIR__ . '/auth.php';

Route::middleware('redirect.by.role')->group(function () {
    Route::get('/', [LoginController::class, 'indexIngresarCliente'])->name('home');
});

Route::get('/slin/comprobante/ver', [SlinController::class, 'verComprobante'])->name('slin.comprobante.ver');
Route::get('/cavali/constancia/ver/{numeroLetra}', [CavaliController::class, 'verLetra'])->name('cavali.constancia.ver');
Route::post('/consulta-codigo-cliente', [ConsultaCodigoClienteController::class, 'consultarClienteDbApi'])->name('consulta-codigo-cliente');
