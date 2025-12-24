<?php

use App\Http\Controllers\Admin\ImagenController;
use App\Livewire\Marketing\Archivo\ArchivoTodoLivewire;
use App\Livewire\Marketing\Imagen\ImagenTodoLivewire;
use Illuminate\Support\Facades\Route;

Route::get('/imagen', ImagenTodoLivewire::class)->name('imagen.vista.todo');
Route::post('/upload-local-imagen', [ImagenController::class, 'uploadLocalImagen'])->name('imagen.upload-local');

Route::get('/archivo', ArchivoTodoLivewire::class)->name('archivo.vista.todo');
