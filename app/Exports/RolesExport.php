<?php

namespace App\Exports;

use Spatie\Permission\Models\Role;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RolesExport implements FromCollection, WithHeadings, WithMapping
{
    protected string $buscar;

    public function __construct(string $buscar = '')
    {
        $this->buscar = $buscar;
    }

    public function collection()
    {
        return Role::query()
            ->where('name', '!=', 'super-admin')
            ->when($this->buscar, fn ($q) =>
                $q->where('name', 'like', "%{$this->buscar}%")
            )
            ->orderBy('name')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nombre',
            'Fecha Creación',
        ];
    }

    public function map($role): array
    {
        return [
            $role->id,
            $role->name,
            optional($role->created_at)->format('d/m/Y'),
        ];
    }
}
