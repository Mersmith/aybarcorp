<?php

namespace App\Livewire\Atc\EvidenciaPagoAntiguo;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\EvidenciaPagoAntiguoImport;
use Illuminate\Validation\ValidationException;

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

        try {
            Excel::import(new EvidenciaPagoAntiguoImport, $this->archivo);

            $this->dispatch('alertaLivewire', ['title' => 'Importado', 'text' => 'Se importó correctamente.']);
        } catch (ValidationException $e) {

            $this->addError(
                'archivo',
                $e->errors()['archivo'][0] ?? 'Error en el archivo'
            );
        } catch (\Throwable $e) {

            $this->addError(
                'archivo',
                'Ocurrió un error inesperado durante la importación'
            );
        }
    }

    public function render()
    {
        return view('livewire.atc.evidencia-pago-antiguo.evidencia-pago-antiguo-importar-livewire');
    }
}
