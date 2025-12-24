<?php

namespace App\Livewire\Marketing\Imagen;

use App\Models\Imagen;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;;
use Livewire\Attributes\On;

class ImagenListaLivewire extends Component
{
    use WithPagination;

    protected $listeners = ['formularioImagenGuardada' => '$refresh'];

    #[On('listaEliminarImagen')]
    public function eliminarImagen($imagenId)
    {
        $imagen = Imagen::find($imagenId);
        if ($imagen) {
            if ($imagen->path && Storage::disk('public')->exists($imagen->path)) {
                Storage::disk('public')->delete($imagen->path);
            }
            $imagen->delete();
            //$this->dispatch('alertaLivewire', "Imagen eliminada correctamente.");
            $this->dispatch('imagenEliminada');
        }
    }

    public function seleccionarImagen($id)
    {
        $this->dispatch('abrirModalEditarImagen', $id);
    }

    public function render()
    {
        $imagenes = Imagen::orderBy('created_at', 'desc')->paginate(30);
        return view('livewire.marketing.imagen.imagen-lista-livewire', compact('imagenes'));
    }
}
