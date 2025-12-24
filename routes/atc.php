<?php

use App\Livewire\Atc\Area\AreaTodoLivewire;
use App\Livewire\Atc\Area\AreaCrearLivewire;
use App\Livewire\Atc\Area\AreaEditarLivewire;
use App\Livewire\Atc\Area\AreaUserLivewire;
use App\Livewire\Atc\Area\AreaSolicitudLivewire;

use App\Livewire\Atc\EstadoEvidenciaPago\EstadoEvidenciaPagoTodoLivewire;
use App\Livewire\Atc\EstadoEvidenciaPago\EstadoEvidenciaPagoCrearLivewire;
use App\Livewire\Atc\EstadoEvidenciaPago\EstadoEvidenciaPagoEditarLivewire;

use App\Livewire\Atc\EvidenciaPago\EvidenciaPagoTodoLivewire;
use App\Livewire\Atc\EvidenciaPago\EvidenciaPagoEditarLivewire;
use App\Livewire\Atc\EvidenciaPago\ImportarEvidenciaAntiguoLivewire;

use Illuminate\Support\Facades\Route;

Route::prefix('area')->name('area.vista.')->group(function () {
    Route::get('/', AreaTodoLivewire::class)->name('todo');
    Route::get('/crear', AreaCrearLivewire::class)->name('crear');
    Route::get('/editar/{id}', AreaEditarLivewire::class)->name('editar');
    Route::get('/user/{id}', AreaUserLivewire::class)->name('user');
    Route::get('/solicitud/{id}', AreaSolicitudLivewire::class)->name('solicitud');
});

Route::prefix('estado-evidencia-pago')
    ->name('estado-evidencia-pago.vista.')
    ->middleware(['role:super-admin|supervisor gestor'])
    ->group(function () {
        Route::get('/', EstadoEvidenciaPagoTodoLivewire::class)->name('todo');
        Route::get('/crear', EstadoEvidenciaPagoCrearLivewire::class)->name('crear');
        Route::get('/editar/{id}', EstadoEvidenciaPagoEditarLivewire::class)->name('editar');
    });

Route::prefix('evidencia-pago')
    ->name('evidencia-pago.vista.')
    ->middleware(['role:super-admin|supervisor gestor|gestor'])
    ->group(function () {
        Route::get('/', EvidenciaPagoTodoLivewire::class)->name('todo');
        Route::get('/editar/{id}', EvidenciaPagoEditarLivewire::class)->name('editar');
        Route::get('/importar-antiguo', ImportarEvidenciaAntiguoLivewire::class)->name('importar-antiguo');
    });
