<?php

use App\Livewire\Admin\Inicio\InicioLivewire;
use Illuminate\Support\Facades\Route;

Route::get('/perfil', InicioLivewire::class)->name('home');
