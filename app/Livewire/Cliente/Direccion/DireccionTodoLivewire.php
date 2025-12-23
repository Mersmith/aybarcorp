<?php

namespace App\Livewire\Cliente\Direccion;

use App\Models\Direccion;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class DireccionTodoLivewire extends Component
{
    public $direcciones;
    public $estadoModalEditar = false;
    public $estadoModalEliminar = false;
    public $estadoModalCrear = false;
    public $editar_direccion_id;
    public $eliminar_direccion_id;

    public function mount()
    {
        $this->refreshDirecciones();
    }

    #[On('emitCompradorRefreshDirecciones')]
    public function refreshDirecciones()
    {
        $usuario = Auth::user();

        if ($usuario) {
            $this->direcciones = $usuario->direcciones()->orderBy('es_principal', 'desc')->get();
        } else {
            $this->direcciones = collect();
        }
    }

    public function editarDireccion($direccionId)
    {
        $this->estadoModalEditar = true;
        $this->editar_direccion_id = $direccionId;
    }

    public function establecerPrincipal($direccionId)
    {
        $usuario = Auth::user();

        Direccion::where('user_id', $usuario->id)
            ->where('es_principal', true)
            ->update(['es_principal' => false]);

        Direccion::where('id', $direccionId)
            ->where('user_id', $usuario->id)
            ->update(['es_principal' => true]);

        $this->mount();
    }

    #[On('emitCompradorCerrarModalCrearDireccion')]
    public function cerrarModalCrear()
    {
        $this->estadoModalCrear = false;
    }

    #[On('emitCompradorCerrarModalEditarDireccion')]
    public function cerrarModalEditar()
    {
        $this->estadoModalEditar = false;
    }

    public function confirmDelete($direccionId)
    {
        $this->eliminar_direccion_id = $direccionId;
        $this->estadoModalEliminar = true;
    }

    public function deleteDireccion()
    {
        Direccion::destroy($this->eliminar_direccion_id);
        $this->mount();
        $this->reset(['eliminar_direccion_id']);
        $this->estadoModalEliminar = false;
    }

    public function render()
    {
        return view('livewire.cliente.direccion.direccion-todo-livewire');
    }
}
