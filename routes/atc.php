<?php

use App\Livewire\Atc\Canal\CanalCrearLivewire;
use App\Livewire\Atc\Canal\CanalEditarLivewire;
use App\Livewire\Atc\Canal\CanalTodoLivewire;
use App\Livewire\Atc\EstadoTicket\EstadoTicketCrearLivewire;
use App\Livewire\Atc\EstadoTicket\EstadoTicketEditarLivewire;
use App\Livewire\Atc\EstadoTicket\EstadoTicketTodoLivewire;
use App\Livewire\Atc\PrioridadTicket\PrioridadTicketCrearLivewire;
use App\Livewire\Atc\PrioridadTicket\PrioridadTicketEditarLivewire;
use App\Livewire\Atc\PrioridadTicket\PrioridadTicketTodoLivewire;
use App\Livewire\Atc\Reporte\ReporteLivewire;
use App\Livewire\Atc\SubTipoSolicitud\SubTipoSolicitudCrearLivewire;
use App\Livewire\Atc\SubTipoSolicitud\SubTipoSolicitudEditarLivewire;
use App\Livewire\Atc\SubTipoSolicitud\SubTipoSolicitudTodoLivewire;
use App\Livewire\Atc\Ticket\TicketCrearLivewire;
use App\Livewire\Atc\Ticket\TicketDerivadoLivewire;
use App\Livewire\Atc\Ticket\TicketEditarLivewire;
use App\Livewire\Atc\Ticket\TicketTodoLivewire;
use App\Livewire\Atc\TipoSolicitud\TipoSolicitudCrearLivewire;
use App\Livewire\Atc\TipoSolicitud\TipoSolicitudEditarLivewire;
use App\Livewire\Atc\TipoSolicitud\TipoSolicitudTodoLivewire;
use Illuminate\Support\Facades\Route;

Route::prefix('tipo-solicitud')
    ->name('tipo-solicitud.vista.')
    ->middleware(['role:super-admin|admin|supervisor-atc'])
    ->group(function () {
        Route::get('/', TipoSolicitudTodoLivewire::class)->name('todo');
        Route::get('/crear', TipoSolicitudCrearLivewire::class)->name('crear');
        Route::get('/editar/{id}', TipoSolicitudEditarLivewire::class)->name('editar');
    });

Route::prefix('sub-tipo-solicitud')
    ->name('sub-tipo-solicitud.vista.')
    ->middleware(['role:super-admin|admin|supervisor-atc'])
    ->group(function () {
        Route::get('/', SubTipoSolicitudTodoLivewire::class)->name('todo');
        Route::get('/crear', SubTipoSolicitudCrearLivewire::class)->name('crear');
        Route::get('/editar/{id}', SubTipoSolicitudEditarLivewire::class)->name('editar');
    });

Route::prefix('estado-ticket')
    ->name('estado-ticket.vista.')
    ->middleware(['role:super-admin|admin|supervisor-atc'])
    ->group(function () {
        Route::get('/', EstadoTicketTodoLivewire::class)->name('todo');
        Route::get('/crear', EstadoTicketCrearLivewire::class)->name('crear');
        Route::get('/editar/{id}', EstadoTicketEditarLivewire::class)->name('editar');
    });

Route::prefix('prioridad-ticket')
    ->name('prioridad-ticket.vista.')
    ->middleware(['role:super-admin|admin|supervisor-atc'])
    ->group(function () {
        Route::get('/', PrioridadTicketTodoLivewire::class)->name('todo');
        Route::get('/crear', PrioridadTicketCrearLivewire::class)->name('crear');
        Route::get('/editar/{id}', PrioridadTicketEditarLivewire::class)->name('editar');
    });

Route::prefix('canal')
    ->name('canal.vista.')
    ->middleware(['role:super-admin|admin|supervisor-atc'])
    ->group(function () {
        Route::get('/', CanalTodoLivewire::class)->name('todo');
        Route::get('/crear', CanalCrearLivewire::class)->name('crear');
        Route::get('/editar/{id}', CanalEditarLivewire::class)->name('editar');
    });

Route::prefix('ticket')
    ->name('ticket.vista.')
    ->middleware(['role:super-admin|admin|supervisor-atc|asesor-atc'])
    ->group(function () {
        Route::get('/', TicketTodoLivewire::class)->name('todo');
        Route::get('/crear/{ticketPadre?}', TicketCrearLivewire::class)->name('crear');
        Route::get('/editar/{id}', TicketEditarLivewire::class)->name('editar');
        Route::get('/derivado/{id}', TicketDerivadoLivewire::class)->name('derivado');
    });

Route::prefix('reporte-ticket')
    ->name('reporte-ticket.vista.')
    ->middleware(['role:super-admin|admin|supervisor-atc'])
    ->group(function () {
        Route::get('/', ReporteLivewire::class)->name('todo');
    });
