<?php

use App\Livewire\Admin\Cliente\ClienteCrearLivewire;
use App\Livewire\Admin\Cliente\ClienteEditarLivewire;
use App\Livewire\Admin\Cliente\ClienteTodoLivewire;
use App\Livewire\Admin\ClienteAntiguo\ClienteAntiguoCrearLivewire;
use App\Livewire\Admin\ClienteAntiguo\ClienteAntiguoEditarLivewire;
use App\Livewire\Admin\ClienteAntiguo\ClienteAntiguoTodoLivewire;
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
use Illuminate\Support\Facades\Route;

Route::get('/perfil', InicioLivewire::class)->name('home');

Route::prefix('unidad-negocio')->name('unidad-negocio.vista.')->group(function () {
    Route::get('/', UnidadNegocioTodoLivewire::class)->name('todo');
    Route::get('/crear', UnidadNegocioCrearLivewire::class)->name('crear');
    Route::get('/editar/{id}', UnidadNegocioEditarLivewire::class)->name('editar');
});

Route::prefix('cliente')->name('cliente.vista.')->group(function () {
    Route::get('/', ClienteTodoLivewire::class)->name('todo');
    Route::get('/crear', ClienteCrearLivewire::class)->name('crear');
    Route::get('/editar/{id}', ClienteEditarLivewire::class)->name('editar');
});

Route::prefix('cliente-bd-antiguo')->name('cliente-bd-antiguo.vista.')->group(function () {
    Route::get('/', ClienteAntiguoTodoLivewire::class)->name('todo');
    Route::get('/crear', ClienteAntiguoCrearLivewire::class)->name('crear');
    Route::get('/editar/{id}', ClienteAntiguoEditarLivewire::class)->name('editar');
});

Route::prefix('sede')->name('sede.vista.')->group(function () {
    Route::get('/', SedeTodoLivewire::class)->name('todo');
    Route::get('/crear', SedeCrearLivewire::class)->name('crear');
    Route::get('/editar/{id}', SedeEditarLivewire::class)->name('editar');
});

Route::prefix('proyecto')
    ->name('proyecto.vista.')
    ->group(function () {
        Route::get('/', ProyectoTodoLivewire::class)->name('todo');
        Route::get('/crear', ProyectoCrearLivewire::class)->name('crear');
        Route::get('/editar/{id}', ProyectoEditarLivewire::class)->name('editar');
        Route::get('/seccion/{id}', ProyectoSeccionLivewire::class)->name('seccion');
    });

require __DIR__ . '/spatie.php';
require __DIR__ . '/atc.php';
require __DIR__ . '/marketing.php';
