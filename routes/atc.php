<?php

use App\Livewire\Atc\Area\AreaCrearLivewire;
use App\Livewire\Atc\Area\AreaEditarLivewire;
use App\Livewire\Atc\Area\AreaSolicitudLivewire;
use App\Livewire\Atc\Area\AreaTodoLivewire;
use App\Livewire\Atc\Area\AreaUserLivewire;

use App\Livewire\Atc\EstadoEvidenciaPago\EstadoEvidenciaPagoCrearLivewire;
use App\Livewire\Atc\EstadoEvidenciaPago\EstadoEvidenciaPagoEditarLivewire;
use App\Livewire\Atc\EstadoEvidenciaPago\EstadoEvidenciaPagoTodoLivewire;

use App\Livewire\Atc\EvidenciaPago\EvidenciaPagoEditarLivewire;
use App\Livewire\Atc\EvidenciaPago\EvidenciaPagoTodoLivewire;
use App\Livewire\Atc\EvidenciaPago\ImportarEvidenciaAntiguoLivewire;

use App\Livewire\Atc\TipoSolicitud\TipoSolicitudTodoLivewire;
use App\Livewire\Atc\TipoSolicitud\TipoSolicitudCrearLivewire;
use App\Livewire\Atc\TipoSolicitud\TipoSolicitudEditarLivewire;

use App\Livewire\Atc\SubTipoSolicitud\SubTipoSolicitudTodoLivewire;
use App\Livewire\Atc\SubTipoSolicitud\SubTipoSolicitudCrearLivewire;
use App\Livewire\Atc\SubTipoSolicitud\SubTipoSolicitudEditarLivewire;

use App\Livewire\Atc\EstadoTicket\EstadoTicketTodoLivewire;
use App\Livewire\Atc\EstadoTicket\EstadoTicketCrearLivewire;
use App\Livewire\Atc\EstadoTicket\EstadoTicketEditarLivewire;

use App\Livewire\Atc\PrioridadTicket\PrioridadTicketTodoLivewire;
use App\Livewire\Atc\PrioridadTicket\PrioridadTicketCrearLivewire;
use App\Livewire\Atc\PrioridadTicket\PrioridadTicketEditarLivewire;

use App\Livewire\Atc\Canal\CanalTodoLivewire;
use App\Livewire\Atc\Canal\CanalCrearLivewire;
use App\Livewire\Atc\Canal\CanalEditarLivewire;

use App\Livewire\Atc\Ticket\TicketTodoLivewire;
use App\Livewire\Atc\Ticket\TicketCrearLivewire;
use App\Livewire\Atc\Ticket\TicketEditarLivewire;
use App\Livewire\Atc\Ticket\TicketDerivadoLivewire;

use App\Livewire\Atc\Reporte\ReporteLivewire;

use App\Livewire\Atc\MotivoCita\MotivoCitaTodoLivewire;
use App\Livewire\Atc\MotivoCita\MotivoCitaCrearLivewire;
use App\Livewire\Atc\MotivoCita\MotivoCitaEditarLivewire;

use App\Livewire\Atc\EstadoCita\EstadoCitaTodoLivewire;
use App\Livewire\Atc\EstadoCita\EstadoCitaCrearLivewire;
use App\Livewire\Atc\EstadoCita\EstadoCitaEditarLivewire;

use App\Livewire\Atc\Cita\CitaTodoLivewire;
use App\Livewire\Atc\Cita\CitaCalendarioLivewire;
use App\Livewire\Atc\Cita\CitaCrearLivewire;
use App\Livewire\Atc\Cita\CitaEditarLivewire;
use App\Livewire\Atc\EvidenciaPagoAntiguo\EvidenciaPagoAntiguoEditarLivewire;
use App\Livewire\Atc\EvidenciaPagoAntiguo\EvidenciaPagoAntiguoImportarLivewire;
use App\Livewire\Atc\EvidenciaPagoAntiguo\EvidenciaPagoAntiguoTodoLivewire;
use App\Livewire\Atc\ReporteCita\ReporteCitaLivewire;


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
    });

Route::prefix('evidencia-pago-antiguo')
    ->name('evidencia-pago-antiguo.vista.')
    ->middleware(['role:super-admin|admin|supervisor-backoffice|asesor-backoffice'])
    ->group(function () {
        Route::get('/', EvidenciaPagoAntiguoTodoLivewire::class)->name('todo');
        Route::get('/editar/{id}', EvidenciaPagoAntiguoEditarLivewire::class)->name('editar');
        Route::get('/importar', EvidenciaPagoAntiguoImportarLivewire::class)->name('importar');
    });

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
        Route::get('/calendario', CitaCalendarioLivewire::class)->name('calendario');
        Route::get('/crear/{ticketId?}', CitaCrearLivewire::class)->name('crear');
        Route::get('/editar/{id}', CitaEditarLivewire::class)->name('editar');
    });

Route::prefix('reporte-cita')
    ->name('reporte-cita.vista.')
    ->middleware(['role:super-admin|admin|supervisor-atc'])
    ->group(function () {
        Route::get('/', ReporteCitaLivewire::class)->name('todo');
    });
