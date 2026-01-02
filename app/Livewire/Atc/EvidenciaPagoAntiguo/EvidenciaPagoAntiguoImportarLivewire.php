<?php

namespace App\Livewire\Atc\EvidenciaPagoAntiguo;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\EvidenciaPagoAntiguoImport;

#[Layout('layouts.admin.layout-admin')]
class EvidenciaPagoAntiguoImportarLivewire extends Component
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
        return view('livewire.atc.evidencia-pago-antiguo.evidencia-pago-antiguo-importar-livewire');
    }
}
