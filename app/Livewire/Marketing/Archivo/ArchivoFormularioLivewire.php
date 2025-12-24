<?php

namespace App\Livewire\Marketing\Archivo;

use App\Models\Archivo;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class ArchivoFormularioLivewire extends Component
{
    use WithFileUploads;

    public $archivos_inicial = [], $archivos_final = [];

    public function updatedArchivosInicial($archivos_inicial)
    {
        foreach ($archivos_inicial as $archivo) {
            $this->archivos_final[] = $archivo;
        }
    }

    public function eliminarArchivoTemporal($index)
    {
        array_splice($this->archivos_final, $index, 1);
    }

    public function guardar()
    {
        if (empty($this->archivos_final)) {
            $this->addError('archivos_final', 'Debe seleccionar al menos una archivo.');
            return;
        }

        foreach ($this->archivos_final as $archivo) {
            $ruta = $archivo->store('archivos', 'public');
            $url = Storage::url($ruta);

            Archivo::create([
                'titulo' => null,
                'descripcion' => null,
                'path' => $ruta,
                'url' => $url,
            ]);
        }

        $this->reset(['archivos_inicial', 'archivos_final']);
        $this->resetErrorBag();

        //$this->dispatch('alertaLivewire', "Imágenes subidas correctamente.");
        $this->dispatch('formularioArchivoGuardada');
    }

    public function render()
    {
        return view('livewire.marketing.archivo.archivo-formulario-livewire');
    }
}
