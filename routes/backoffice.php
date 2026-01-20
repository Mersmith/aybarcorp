<?php

use App\Livewire\Backoffice\EstadoEvidenciaPago\EstadoEvidenciaPagoCrearLivewire;
use App\Livewire\Backoffice\EstadoEvidenciaPago\EstadoEvidenciaPagoEditarLivewire;
use App\Livewire\Backoffice\EstadoEvidenciaPago\EstadoEvidenciaPagoTodoLivewire;
use App\Livewire\Backoffice\EvidenciaPagoAntiguo\EvidenciaPagoAntiguoCrearLivewire;
use App\Livewire\Backoffice\EvidenciaPagoAntiguo\EvidenciaPagoAntiguoEditarLivewire;
use App\Livewire\Backoffice\EvidenciaPagoAntiguo\EvidenciaPagoAntiguoImportarLivewire;
use App\Livewire\Backoffice\EvidenciaPagoAntiguo\EvidenciaPagoAntiguoReporteLivewire;
use App\Livewire\Backoffice\EvidenciaPagoAntiguo\EvidenciaPagoAntiguoTodoLivewire;
use App\Livewire\Backoffice\EvidenciaPago\EvidenciaPagoEditarLivewire;
use App\Livewire\Backoffice\EvidenciaPago\EvidenciaPagoReporteLivewire;
use App\Livewire\Backoffice\EvidenciaPago\EvidenciaPagoTodoLivewire;
use Illuminate\Support\Facades\Route;

Route::prefix('estado-evidencia-pago')
    ->name('estado-evidencia-pago.vista.')
    ->middleware(['role:super-admin|admin|supervisor-backoffice'])
    ->group(function () {
        Route::get('/', EstadoEvidenciaPagoTodoLivewire::class)->name('todo');
        Route::get('/crear', EstadoEvidenciaPagoCrearLivewire::class)->name('crear');
        Route::get('/editar/{id}', EstadoEvidenciaPagoEditarLivewire::class)->name('editar');
    });

Route::prefix('evidencia-pago')
    ->name('evidencia-pago.vista.')
    ->middleware(['role:super-admin|admin|supervisor-backoffice|asesor-backoffice'])
    ->group(function () {
        Route::get('/', EvidenciaPagoTodoLivewire::class)->name('todo');
        Route::get('/editar/{id}', EvidenciaPagoEditarLivewire::class)->name('editar');
        Route::get('/reporte', EvidenciaPagoReporteLivewire::class)->name('reporte');
    });

Route::prefix('evidencia-pago-antiguo')
    ->name('evidencia-pago-antiguo.vista.')
    ->middleware(['role:super-admin|admin|supervisor-backoffice|asesor-backoffice'])
    ->group(function () {
        Route::get('/', EvidenciaPagoAntiguoTodoLivewire::class)->name('todo');
        Route::get('/crear', EvidenciaPagoAntiguoCrearLivewire::class)->name('crear');
        Route::get('/editar/{id}', EvidenciaPagoAntiguoEditarLivewire::class)->name('editar');
        Route::get('/importar', EvidenciaPagoAntiguoImportarLivewire::class)->name('importar');
        Route::get('/reporte', EvidenciaPagoAntiguoReporteLivewire::class)->name('reporte');
    });
