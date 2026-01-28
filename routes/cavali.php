<?php

use App\Livewire\Cavali\SolicitarLetraDigital\EnvioCavaliDetalleTodoLivewire;
use App\Livewire\Cavali\SolicitarLetraDigital\SolicitarLetraDigitalTodoLivewire;
use Illuminate\Support\Facades\Route;

Route::prefix('solicitar-letra-digital')->name('solicitar-letra-digital.vista.')->group(function () {
    Route::get('/', SolicitarLetraDigitalTodoLivewire::class)->name('todo');
});

Route::get('cavali/envios/{envio}', EnvioCavaliDetalleTodoLivewire::class)->name('cavali.envios.show');
