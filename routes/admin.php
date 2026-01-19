<?php

use App\Livewire\Admin\ClienteAntiguo\ClienteAntiguoCrearLivewire;
use App\Livewire\Admin\ClienteAntiguo\ClienteAntiguoEditarLivewire;
use App\Livewire\Admin\ClienteAntiguo\ClienteAntiguoTodoLivewire;
use App\Livewire\Admin\Cliente\ClienteEditarLivewire;
use App\Livewire\Admin\Cliente\ClienteReporteLivewire;
use App\Livewire\Admin\Cliente\ClienteConsultarLivewire;
use App\Livewire\Admin\Cliente\ClienteTodoLivewire;
use App\Livewire\Admin\GrupoProyecto\GrupoProyectoCrearLivewire;
use App\Livewire\Admin\GrupoProyecto\GrupoProyectoEditarLivewire;
use App\Livewire\Admin\GrupoProyecto\GrupoProyectoTodoLivewire;
use App\Livewire\Admin\Inicio\InicioLivewire;
use App\Livewire\Admin\Proyecto\ProyectoCrearLivewire;
use App\Livewire\Admin\Proyecto\ProyectoEditarLivewire;
use App\Livewire\Admin\Proyecto\ProyectoSeccionLivewire;
use App\Livewire\Admin\Proyecto\ProyectoTodoLivewire;
use App\Livewire\Admin\Sede\SedeCrearLivewire;
use App\Livewire\Admin\Sede\SedeEditarLivewire;
use App\Livewire\Admin\Sede\SedeTodoLivewire;
use App\Livewire\Admin\UnidadNegocio\UnidadNegocioCrearLivewire;
use App\Livewire\Admin\UnidadNegocio\UnidadNegocioEditarLivewire;
use App\Livewire\Admin\UnidadNegocio\UnidadNegocioTodoLivewire;
use App\Livewire\Admin\User\UserCrearLivewire;
use App\Livewire\Admin\User\UserEditarLivewire;
use App\Livewire\Admin\User\UserTodoLivewire;
use App\Livewire\Atc\Area\AreaCrearLivewire;
use App\Livewire\Atc\Area\AreaEditarLivewire;
use App\Livewire\Atc\Area\AreaSolicitudLivewire;
use App\Livewire\Atc\Area\AreaTodoLivewire;
use App\Livewire\Atc\Area\AreaUserLivewire;
use Illuminate\Support\Facades\Route;

Route::get('/perfil', InicioLivewire::class)->name('home'); //ok

Route::prefix('usuario')->name('usuario.vista.')->group(function () { //ok
    Route::get('/', UserTodoLivewire::class)->name('todo');
    Route::get('/crear', UserCrearLivewire::class)->name('crear');
    Route::get('/editar/{id}', UserEditarLivewire::class)->name('editar');
});

Route::prefix('cliente')->name('cliente.vista.')->group(function () { //ok
    Route::get('/', ClienteTodoLivewire::class)->name('todo');
    Route::get('/consultar/{dni?}', ClienteConsultarLivewire::class)->name('consultar');
    Route::get('/editar/{id}', ClienteEditarLivewire::class)->name('editar');
    Route::get('/reporte', ClienteReporteLivewire::class)->name('reporte');
});

Route::prefix('cliente-bd-antiguo')->name('cliente-bd-antiguo.vista.')->group(function () { //ok
    Route::get('/', ClienteAntiguoTodoLivewire::class)->name('todo');
    Route::get('/crear', ClienteAntiguoCrearLivewire::class)->name('crear');
    Route::get('/editar/{id}', ClienteAntiguoEditarLivewire::class)->name('editar');
});

Route::prefix('unidad-negocio')->name('unidad-negocio.vista.')->group(function () { //ok
    Route::get('/', UnidadNegocioTodoLivewire::class)->name('todo');
    Route::get('/crear', UnidadNegocioCrearLivewire::class)->name('crear');
    Route::get('/editar/{id}', UnidadNegocioEditarLivewire::class)->name('editar');
});

Route::prefix('sede')->name('sede.vista.')->group(function () { //ok
    Route::get('/', SedeTodoLivewire::class)->name('todo');
    Route::get('/crear', SedeCrearLivewire::class)->name('crear');
    Route::get('/editar/{id}', SedeEditarLivewire::class)->name('editar');
});

Route::prefix('area')->name('area.vista.')->group(function () { //ok
    Route::get('/', AreaTodoLivewire::class)->name('todo');
    Route::get('/crear', AreaCrearLivewire::class)->name('crear');
    Route::get('/editar/{id}', AreaEditarLivewire::class)->name('editar');
    Route::get('/user/{id}', AreaUserLivewire::class)->name('user');
    Route::get('/solicitud/{id}', AreaSolicitudLivewire::class)->name('solicitud');
});

Route::prefix('grupo-proyecto')->name('grupo-proyecto.vista.')->group(function () { //ok
    Route::get('/', GrupoProyectoTodoLivewire::class)->name('todo');
    Route::get('/crear', GrupoProyectoCrearLivewire::class)->name('crear');
    Route::get('/editar/{id}', GrupoProyectoEditarLivewire::class)->name('editar');
});

Route::prefix('proyecto')->name('proyecto.vista.')->group(function () { //ok
    Route::get('/', ProyectoTodoLivewire::class)->name('todo');
    Route::get('/crear', ProyectoCrearLivewire::class)->name('crear');
    Route::get('/editar/{id}', ProyectoEditarLivewire::class)->name('editar');
    Route::get('/seccion/{id}', ProyectoSeccionLivewire::class)->name('seccion');
});

require __DIR__ . '/spatie.php';
require __DIR__ . '/atc.php';
require __DIR__ . '/backoffice.php';
require __DIR__ . '/cita.php';
require __DIR__ . '/cavali.php';
//require __DIR__ . '/marketing.php';
