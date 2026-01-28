<?php

namespace App\Livewire\Cavali\SolicitarLetraDigital;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\EnvioCavali;
use App\Exports\{
    CavaliAceptanteExport,
    CavaliLetrasExport,
    CavaliGiradorExport
};
use Maatwebsite\Excel\Facades\Excel;

#[Layout('layouts.admin.layout-admin')]
class EnvioCavaliDetalleTodoLivewire extends Component
{
    public EnvioCavali $envio;

    public function mount(EnvioCavali $envio)
    {
        // cargamos relaciones necesarias
        $this->envio = $envio->load([
            'solicitudes.unidadNegocio',
            'solicitudes.userCliente.cliente',
            'solicitudes.userCliente.direcciones.distrito',
        ]);
    }

    public function descargarAceptantes()
    {
        return Excel::download(
            new CavaliAceptanteExport($this->envio),
            "ACEPTANTE_{$this->envio->id}.xlsx"
        );
    }

    public function descargarLetras()
    {
        return Excel::download(
            new CavaliLetrasExport($this->envio),
            "LETRAS_{$this->envio->id}.xlsx"
        );
    }

    public function descargarGirador()
    {
        return Excel::download(
            new CavaliGiradorExport($this->envio),
            "GIRADOR_{$this->envio->id}.xlsx"
        );
    }

    public function render()
    {
        return view('livewire.cavali.solicitar-letra-digital.envio-cavali-detalle-todo-livewire');
    }
}
