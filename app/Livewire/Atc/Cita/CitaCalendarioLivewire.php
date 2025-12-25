<?php

namespace App\Livewire\Atc\Cita;

use App\Models\Cita;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Carbon\Carbon;

#[Layout('layouts.admin.layout-admin')]
class CitaCalendarioLivewire extends Component
{
    public $vista = 'mes';
    public $fechaActual;
    public $eventos = [];

    public function mount()
    {
        $this->fechaActual = Carbon::now();
        $this->loadEventos();
    }

    public function cambiarVista($vista)
    {
        $this->vista = $vista;
        $this->loadEventos();
    }

    public function navegar($valor)
    {
        match ($this->vista) {
            'mes'    => $this->fechaActual->addMonths($valor),
            'semana' => $this->fechaActual->addWeeks($valor),
            'dia'    => $this->fechaActual->addDays($valor),
            'anio'   => $this->fechaActual->addYears($valor),
        };

        $this->loadEventos();
    }

    public function irAlMes($mes)
    {
        $this->vista = 'mes';
        $this->fechaActual->setMonth($mes);
        $this->loadEventos();
    }

    public function irAlDiaDeMes($dia)
    {
        $this->vista = 'dia';
        $this->fechaActual->setDay($dia);
        $this->loadEventos();
    }

    public function irAlDiaDeSemana($fecha)
    {
        $this->vista = 'dia';
        $this->fechaActual = Carbon::parse($fecha);
        $this->loadEventos();
    }

    public function irHoy()
    {
        $this->fechaActual = Carbon::now();
        $this->vista = 'dia'; // O si quieres mantener la vista actual, quita esta línea
        $this->loadEventos();
    }

    public function loadEventos()
    {
        $inicio = match ($this->vista) {
            'mes'    => $this->fechaActual->copy()->startOfMonth(),
            'semana' => $this->fechaActual->copy()->startOfWeek(Carbon::MONDAY),
            'dia'    => $this->fechaActual->copy()->startOfDay(),
            'anio'   => $this->fechaActual->copy()->startOfYear(),
        };

        $fin = match ($this->vista) {
            'mes'    => $this->fechaActual->copy()->endOfMonth(),
            'semana' => $this->fechaActual->copy()->endOfWeek(Carbon::SUNDAY),
            'dia'    => $this->fechaActual->copy()->endOfDay(),
            'anio'   => $this->fechaActual->copy()->endOfYear(),
        };

        $this->eventos = Cita::with(['receptor', 'sede', 'motivo'])
            ->whereBetween('fecha_inicio', [$inicio, $fin])
            ->orderBy('fecha_inicio')
            ->get()
            ->map(fn($cita) => [
                'id'        => $cita->id,
                'title'     => $cita->motivo->nombre,
                'cliente'   => $cita->receptor?->name,
                'sede'      => $cita->sede?->nombre,
                'estado'    => $cita->estado,
                'date'      => $cita->fecha_inicio->toDateString(),
                'time'      => $cita->fecha_inicio->format('H:i'),
                'end_time'  => $cita->fecha_fin?->format('H:i'),
            ])
            ->toArray();
    }

    public function render()
    {
        return view('livewire.atc.cita.cita-calendario-livewire');
    }
}
