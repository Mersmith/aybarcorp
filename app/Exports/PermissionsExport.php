<?php

namespace App\Exports;

use Spatie\Permission\Models\Permission;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PermissionsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected string $buscar;

    public function __construct(string $buscar = '')
    {
        $this->buscar = $buscar;
    }

    public function collection()
    {
        return Permission::where('name', 'like', "%{$this->buscar}%")
            ->orderBy('name')
            ->get(['id', 'name', 'created_at']);
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nombre',
            'Fecha Creación',
        ];
    }
}
