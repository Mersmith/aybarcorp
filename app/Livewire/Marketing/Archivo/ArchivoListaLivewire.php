<?php

namespace App\Livewire\Marketing\Archivo;

use App\Models\Archivo;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;;

use Livewire\Attributes\On;

class ArchivoListaLivewire extends Component
{
    use WithPagination;

    protected $listeners = ['formularioArchivoGuardada' => '$refresh'];

    #[On('listaEliminarArchivo')]
    public function eliminarArchivo($archivoId)
    {
        $archivo = Archivo::find($archivoId);
        if ($archivo) {
            if ($archivo->path && Storage::disk('public')->exists($archivo->path)) {
                Storage::disk('public')->delete($archivo->path);
            }
            $archivo->delete();
            //$this->dispatch('alertaLivewire', "Archivo eliminada correctamente.");
            $this->dispatch('archivoEliminada');
        }
    }

    public function seleccionarArchivo($id)
    {
        $this->dispatch('abrirModalEditarArchivo', $id);
    }

    public function render()
    {
        $archivos = Archivo::orderBy('created_at', 'desc')->paginate(30);

        return view('livewire.marketing.archivo.archivo-lista-livewire', compact('archivos'));
    }
}
