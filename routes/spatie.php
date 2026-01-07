<?php

use App\Livewire\Spatie\Permiso\PermisoCrearLivewire;
use App\Livewire\Spatie\Permiso\PermisoEditarLivewire;
use App\Livewire\Spatie\Permiso\PermisoTodoLivewire;
use App\Livewire\Spatie\Rol\RolCrearLivewire;
use App\Livewire\Spatie\Rol\RolEditarLivewire;
use App\Livewire\Spatie\Rol\RolTodoLivewire;
use Illuminate\Support\Facades\Route;

Route::prefix('rol')->name('rol.vista.')->group(function () { //ok
    Route::get('/', RolTodoLivewire::class)->name('todo');
    Route::get('/crear', RolCrearLivewire::class)->name('crear');
    Route::get('/editar/{id}', RolEditarLivewire::class)->name('editar');
});

Route::prefix('permiso')->name('permiso.vista.')->group(function () {//ok
    Route::get('/', PermisoTodoLivewire::class)->name('todo');
    Route::get('/crear', PermisoCrearLivewire::class)->name('crear');
    Route::get('/editar/{id}', PermisoEditarLivewire::class)->name('editar');
});