<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AdminsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected string $buscar;
    protected int $perPage;
    protected int $page;

    public function __construct(string $buscar, int $perPage, int $page)
    {
        $this->buscar  = $buscar;
        $this->perPage = $perPage;
        $this->page    = $page;
    }

    public function collection()
    {
        return User::with('roles')
            ->where('rol', 'admin')
            ->whereDoesntHave('roles', function ($q) {
                $q->whereIn('name', ['super-admin', 'cliente']);
            })
            ->where('name', 'like', "%{$this->buscar}%")
            ->orderByDesc('created_at')
            ->skip(($this->page - 1) * $this->perPage)
            ->take($this->perPage)
            ->get()
            ->map(fn ($user) => [
                $user->id,
                $user->name,
                $user->email,
                $user->roles->pluck('name')->implode(', '),
                $user->activo ? 'Activo' : 'Inactivo',
                $user->created_at->format('Y-m-d H:i'),
            ]);
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nombre',
            'Email',
            'Roles',
            'Estado',
            'Fecha Creación',
        ];
    }
}
