<?php

namespace App\Livewire\Marketing\Imagen;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Attributes\On;

#[Layout('layouts.admin.layout-admin')]
class ImagenTodoLivewire extends Component
{
    public $imagenSeleccionadaId = null;    

    #[On('abrirModalEditarImagen')]
    public function abrirModalEditar($imagenId)
    {
        $this->imagenSeleccionadaId = $imagenId;
    }

    #[On('cerrarModalEditarImagen')]
    public function cerrarModalEditar()
    {
        $this->imagenSeleccionadaId = null;
    }

    public function render()
    {
        return view('livewire.marketing.imagen.imagen-todo-livewire');
    }
}
