<?php

namespace App\Exports;

use App\Models\Cita;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CitasExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected ?string $buscar;
    protected ?int $unidadNegocio;
    protected ?int $proyecto;
    protected ?int $sede;
    protected ?int $area;
    protected ?int $motivo;
    protected ?int $estado;
    protected ?int $admin;
    protected ?string $fechaInicio;
    protected ?string $fechaFin;
    protected int $perPage;
    protected int $page;

    public function __construct(
        $buscar,
        $unidadNegocio,
        $proyecto,
        $sede,
        $area,
        $motivo,
        $estado,
        $admin,
        $fechaInicio,
        $fechaFin,
        $perPage,
        $page,
    ) {
        $this->buscar = $buscar;
        $this->unidadNegocio = $unidadNegocio !== '' ? (int) $unidadNegocio : null;
        $this->proyecto = $proyecto !== '' ? (int) $proyecto : null;
        $this->sede = $sede !== '' ? (int) $sede : null;
        $this->area = $area !== '' ? (int) $area : null;
        $this->motivo = $motivo !== '' ? (int) $motivo : null;
        $this->admin = $admin !== '' ? (int) $admin : null;
        $this->estado = $estado !== '' ? (int) $estado : null;
        $this->fechaInicio = $fechaInicio ?: null;
        $this->fechaFin = $fechaFin ?: null;
        $this->perPage = (int) $perPage;
        $this->page = (int) $page;
    }

    public function collection()
    {
        return Cita::query()
            ->when($this->buscar, function ($query) {
                $query->where(function ($q) {
                    $q->where('id', 'like', "%{$this->buscar}%")
                        ->orWhere('dni', 'like', "%{$this->buscar}%")
                        ->orWhere('nombres', 'like', "%{$this->buscar}%");
                });
            })
            ->when($this->unidadNegocio, fn($q) => $q->where('unidad_negocio_id', $this->unidadNegocio))
            ->when($this->proyecto, fn($q) => $q->where('proyecto_id', $this->proyecto))
            ->when($this->sede, fn($q) => $q->where('sede_id', $this->sede))
            ->when($this->estado, fn($q) => $q->where('estado_cita_id', $this->estado))
            ->when($this->area, fn($q) => $q->where('area_id', $this->area))
            ->when($this->motivo, fn($q) => $q->where('motivo_cita_id', $this->motivo))
            ->when($this->admin, fn($q) => $q->where('gestor_id', $this->admin))
            ->when($this->fechaInicio, fn($q) => $q->whereDate('created_at', '>=', $this->fechaInicio))
            ->when($this->fechaFin, fn($q) => $q->whereDate('created_at', '<=', $this->fechaFin))
            ->orderByDesc('created_at')
            ->skip(($this->page - 1) * $this->perPage)
            ->take($this->perPage)
            ->get()
            ->map(fn($t, $index) => [
                $index + 1,
                $t->id,
                $t->unidadNegocio->nombre ?? '',
                $t->proyecto->nombre ?? '',
                $t->nombres,
                $t->area->nombre ?? '',
                $t->estado->nombre ?? '',
                $t->gestor->name ?? '',
                $t->created_at->format('Y-m-d H:i'),
            ]);
    }

    public function headings(): array
    {
        return [
            'N°',
            'ID',
            'Empresa',
            'Proyecto',
            'Cliente',
            'Área',
            'Estado',
            'Gestor',
            'Fecha',
        ];
    }
}
