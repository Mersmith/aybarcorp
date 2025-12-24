<?php

namespace App\Livewire\Marketing\Archivo;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Attributes\On;

#[Layout('layouts.admin.layout-admin')]
class ArchivoTodoLivewire extends Component
{
    public $archivoSeleccionadaId = null;

    #[On('abrirModalEditarArchivo')]
    public function abrirModalEditar($archivoId)
    {
        $this->archivoSeleccionadaId = $archivoId;
    }

    #[On('cerrarModalEditarArchivo')]
    public function cerrarModalEditar()
    {
        $this->archivoSeleccionadaId = null;
    }

    public function render()
    {
        return view('livewire.marketing.archivo.archivo-todo-livewire');
    }
}
