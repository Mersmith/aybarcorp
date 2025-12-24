<?php

namespace App\Livewire\Atc\EvidenciaPago;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\EvidenciaPagoAntiguoImport;

#[Layout('layouts.admin.layout-admin')]
class ImportarEvidenciaAntiguoLivewire extends Component
{
    use WithFileUploads;

    public $archivo;

    public function importar()
    {
        $this->validate([
            'archivo' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new EvidenciaPagoAntiguoImport, $this->archivo);

        $this->dispatch('alertaLivewire', 'Creado');
    }

    public function render()
    {
        return view('livewire.atc.comprobante-pago.importar-comprobante-antiguo-livewire');
    }
}
