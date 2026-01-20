<?php

namespace App\Livewire\Admin\Cliente;

use App\Models\Cliente;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.layout-admin')]
class ClienteReporteDinamicoLivewire extends Component
{
    public $mesSeleccionado;
    public $clientesPorDiaMesActual = [];

    public function mount()
    {
        $this->mesSeleccionado = now()->format('Y-m');
        $this->cargarClientesPorDiaMesActual();
    }

    public function updatedMesSeleccionado()
    {
        $this->cargarClientesPorDiaMesActual();

        $this->dispatch(
            'actualizarGraficoDiaMes',
            $this->clientesPorDiaMesActual
        );
    }

    private function cargarClientesPorDiaMesActual()
    {
        if (
            empty($this->mesSeleccionado) ||
            !str_contains($this->mesSeleccionado, '-')
        ) {
            $this->clientesPorDiaMesActual = [
                'labels' => [],
                'data' => [],
            ];
            return;
        }

        [$year, $month] = explode('-', $this->mesSeleccionado);

        $fecha = Carbon::createFromDate($year, $month, 1);
        $diasDelMes = $fecha->daysInMonth;

        $clientes = Cliente::query()
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->selectRaw('DAY(created_at) as dia, COUNT(*) as total')
            ->groupBy('dia')
            ->pluck('total', 'dia');

        $this->clientesPorDiaMesActual = [
            'labels' => range(1, $diasDelMes),
            'data' => collect(range(1, $diasDelMes))
                ->map(fn($dia) => $clientes[$dia] ?? 0)
                ->toArray(),
        ];
    }

    public function render()
    {
        return view('livewire.admin.cliente.cliente-reporte-dinamico-livewire');
    }
}
