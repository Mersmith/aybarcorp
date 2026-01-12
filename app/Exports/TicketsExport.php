<?php

namespace App\Exports;

use App\Models\Ticket;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TicketsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected ?string $buscar;
    protected ?int $unidadNegocio;
    protected ?int $proyecto;
    protected ?int $estado;
    protected ?int $area;
    protected ?int $solicitud;
    protected ?int $subTipo;
    protected ?int $canal;
    protected ?int $admin;
    protected ?int $prioridad;
    protected ?string $fechaInicio;
    protected ?string $fechaFin;
    protected ?string $conDerivados;
    protected int $perPage;
    protected int $page;

    public function __construct(
        $buscar,
        $unidadNegocio,
        $proyecto,
        $estado,
        $area,
        $solicitud,
        $subTipo,
        $canal,
        $admin,
        $prioridad,
        $fechaInicio,
        $fechaFin,
        $conDerivados,
        $perPage,
        $page,
    ) {
        $this->buscar = $buscar;
        $this->unidadNegocio = $unidadNegocio !== '' ? (int) $unidadNegocio : null;
        $this->proyecto = $proyecto !== '' ? (int) $proyecto : null;
        $this->estado = $estado !== '' ? (int) $estado : null;
        $this->area = $area !== '' ? (int) $area : null;
        $this->solicitud = $solicitud !== '' ? (int) $solicitud : null;
        $this->subTipo = $subTipo !== '' ? (int) $subTipo : null;
        $this->canal = $canal !== '' ? (int) $canal : null;
        $this->admin = $admin !== '' ? (int) $admin : null;
        $this->prioridad = $prioridad !== '' ? (int) $prioridad : null;
        $this->fechaInicio = $fechaInicio ?: null;
        $this->fechaFin = $fechaFin ?: null;
        $this->conDerivados = $conDerivados;
        $this->perPage = (int) $perPage;
        $this->page = (int) $page;
    }

    public function collection()
    {
        return Ticket::query()
            ->when($this->buscar, function ($query) {
                $query->where(function ($q) {
                    $q->where('id', 'like', "%{$this->buscar}%")
                        ->orWhere('dni', 'like', "%{$this->buscar}%")
                        ->orWhere('nombres', 'like', "%{$this->buscar}%");
                });
            })
            ->when($this->unidadNegocio, fn($q) => $q->where('unidad_negocio_id', $this->unidadNegocio))
            ->when($this->proyecto, fn($q) => $q->where('proyecto_id', $this->proyecto))
            ->when($this->estado, fn($q) => $q->where('estado_ticket_id', $this->estado))
            ->when($this->area, fn($q) => $q->where('area_id', $this->area))
            ->when($this->solicitud, fn($q) => $q->where('tipo_solicitud_id', $this->solicitud))
            ->when($this->subTipo, fn($q) => $q->where('sub_tipo_solicitud_id', $this->subTipo))
            ->when($this->canal, fn($q) => $q->where('canal_id', $this->canal))
            ->when($this->admin, fn($q) => $q->where('gestor_id', $this->admin))
            ->when($this->prioridad, fn($q) => $q->where('prioridad_ticket_id', $this->prioridad))
            ->when($this->fechaInicio, fn($q) => $q->whereDate('created_at', '>=', $this->fechaInicio))
            ->when($this->fechaFin, fn($q) => $q->whereDate('created_at', '<=', $this->fechaFin))
            ->when(
                $this->conDerivados === '1',
                fn($q) => $q->whereHas('derivados')
            )
            ->when(
                $this->conDerivados === '0',
                fn($q) => $q->whereDoesntHave('derivados')
            )
            ->orderByDesc('created_at')
            ->skip(($this->page - 1) * $this->perPage)
            ->take($this->perPage)
            ->get()
            ->map(fn($t, $index) => [
                $index + 1,
                $t->id,
                $t->nombres,
                $t->area->nombre ?? '',
                $t->tipoSolicitud->nombre ?? '',
                $t->canal->nombre ?? '',
                $t->estado->nombre ?? '',
                $t->gestor->name ?? '',
                $t->prioridad->nombre ?? '',
                $t->created_at->format('Y-m-d H:i'),
                $t->tiene_derivados ? 'Sí' : 'No',
            ]);
    }

    public function headings(): array
    {
        return [
            'N°',
            'Ticket',
            'Cliente',
            'Área',
            'Solicitud',
            'Canal',
            'Estado',
            'Gestor',
            'Prioridad',
            'Fecha',
            'Derivado',
        ];
    }
}
