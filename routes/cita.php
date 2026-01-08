<?php

use App\Livewire\Atc\Cita\CitaCalendarioLivewire;
use App\Livewire\Atc\Cita\CitaCrearLivewire;
use App\Livewire\Atc\Cita\CitaEditarLivewire;
use App\Livewire\Atc\Cita\CitaTodoLivewire;
use App\Livewire\Atc\EstadoCita\EstadoCitaCrearLivewire;
use App\Livewire\Atc\EstadoCita\EstadoCitaEditarLivewire;
use App\Livewire\Atc\EstadoCita\EstadoCitaTodoLivewire;
use App\Livewire\Atc\MotivoCita\MotivoCitaCrearLivewire;
use App\Livewire\Atc\MotivoCita\MotivoCitaEditarLivewire;
use App\Livewire\Atc\MotivoCita\MotivoCitaTodoLivewire;
use App\Livewire\Atc\ReporteCita\ReporteCitaLivewire;
use Illuminate\Support\Facades\Route;

Route::prefix('motivo-cita')
    ->name('motivo-cita.vista.')
    ->middleware(['role:super-admin|admin|supervisor-atc'])
    ->group(function () {
        Route::get('/', MotivoCitaTodoLivewire::class)->name('todo');
        Route::get('/crear', MotivoCitaCrearLivewire::class)->name('crear');
        Route::get('/editar/{id}', MotivoCitaEditarLivewire::class)->name('editar');
    });

Route::prefix('estado-cita')
    ->name('estado-cita.vista.')
    ->middleware(['role:super-admin|admin|supervisor-atc'])
    ->group(function () {
        Route::get('/', EstadoCitaTodoLivewire::class)->name('todo');
        Route::get('/crear', EstadoCitaCrearLivewire::class)->name('crear');
        Route::get('/editar/{id}', EstadoCitaEditarLivewire::class)->name('editar');
    });

Route::prefix('cita')
    ->name('cita.vista.')
    ->middleware(['role:super-admin|admin|supervisor-atc|asesor-atc'])
    ->group(function () {
        Route::get('/', CitaTodoLivewire::class)->name('todo');
        Route::get('/crear/{ticketId?}', CitaCrearLivewire::class)->name('crear');
        Route::get('/editar/{id}', CitaEditarLivewire::class)->name('editar');
        Route::get('/calendario', CitaCalendarioLivewire::class)->name('calendario');
    });

Route::prefix('reporte-cita')
    ->name('reporte-cita.vista.')
    ->middleware(['role:super-admin|admin|supervisor-atc'])
    ->group(function () {
        Route::get('/', ReporteCitaLivewire::class)->name('todo');
    });
