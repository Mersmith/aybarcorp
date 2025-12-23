<?php

use App\Http\Controllers\SlinController;
use App\Http\Controllers\CavaliSignerController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->group(function () {

    Route::get('/test-mail', function () {
        Mail::raw('Correo de prueba SMTP', function ($message) {
            $message->to('mersmith14@gmail.com')
                    ->subject('Prueba SMTP Laravel');
        });
    
        return 'Correo enviado';
    });

    Route::get('/symlink', function () {
        Artisan::call('storage:link');
    });

    Route::get('/ping', function () {
        return response()->json(['message' => 'API funcionando correctamente']);
    });

    Route::get('/test-slin/cliente', [SlinController::class, 'probarCliente']);
    Route::get('/test-slin/lotes', [SlinController::class, 'probarLotes']);
    Route::get('/test-slin/cuotas', [SlinController::class, 'probarCuotas']);

    Route::get('/cavali/signer/test', [CavaliSignerController::class, 'test']);

    Route::get('/slin/cliente/{dni}', [SlinController::class, 'getCliente'])->name('slin.cliente');
    Route::get('/slin/lotes', [SlinController::class, 'getLotes'])->name('slin.lotes');
    Route::get('/slin/cuotas', [SlinController::class, 'getCuotas'])->name('slin.cuotas');
});
