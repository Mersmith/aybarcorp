<?php

use App\Livewire\Admin\User\UserTodoLivewire;
use App\Livewire\Admin\User\UserCrearLivewire;
use App\Livewire\Admin\User\UserEditarLivewire;

use App\Livewire\Spatie\Rol\RolTodoLivewire;
use App\Livewire\Spatie\Rol\RolCrearLivewire;
use App\Livewire\Spatie\Rol\RolEditarLivewire;

use App\Livewire\Spatie\Permiso\PermisoTodoLivewire;
use App\Livewire\Spatie\Permiso\PermisoCrearLivewire;
use App\Livewire\Spatie\Permiso\PermisoEditarLivewire;

use Illuminate\Support\Facades\Route;

Route::prefix('usuario')->name('usuario.vista.')->group(function () {
    Route::get('/', UserTodoLivewire::class)->name('todo');
    Route::get('/crear', UserCrearLivewire::class)->name('crear');
    Route::get('/editar/{id}', UserEditarLivewire::class)->name('editar');
});

Route::prefix('rol')->name('rol.vista.')->group(function () {
    Route::get('/', RolTodoLivewire::class)->name('todo');
    Route::get('/crear', RolCrearLivewire::class)->name('crear');
    Route::get('/editar/{id}', RolEditarLivewire::class)->name('editar');
});

Route::prefix('permiso')->name('permiso.vista.')->group(function () {
    Route::get('/', PermisoTodoLivewire::class)->name('todo');
    Route::get('/crear', PermisoCrearLivewire::class)->name('crear');
    Route::get('/editar/{id}', PermisoEditarLivewire::class)->name('editar');
});