<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AdminsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected string $buscar;
    protected string $email;
    protected ?int $rol;
    protected string $activo;
    protected int $perPage;
    protected int $page;

    public function __construct(string $buscar, string $email, ?int $rol, string $activo, int $perPage, int $page)
    {
        $this->buscar = $buscar;
        $this->email = $email;
        $this->rol = $rol;
        $this->activo = $activo;
        $this->perPage = $perPage;
        $this->page = $page;
    }

    public function collection()
    {
        return User::with('roles')
            ->where('rol', 'admin')
            ->whereDoesntHave('roles', function ($q) {
                $q->whereIn('name', ['super-admin', 'cliente']);
            })
            ->when($this->rol, function ($query) {
                $query->whereHas('roles', function ($q) {
                    $q->where('id', $this->rol);
                });
            })
            ->when($this->activo !== '', function ($query) {
                $query->where('activo', $this->activo);
            })
            ->where('name', 'like', "%{$this->buscar}%")
            ->where('email', 'like', "%{$this->email}%")
            ->orderByDesc('created_at')
            ->skip(($this->page - 1) * $this->perPage)
            ->take($this->perPage)
            ->get()
            ->map(function ($user, $index) {
                return [
                    $index + 1,
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->roles->pluck('name')->implode(', '),
                    $user->activo ? 'Activo' : 'Inactivo',
                    $user->created_at->format('Y-m-d H:i'),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'N°',
            'ID',
            'Nombre',
            'Email',
            'Roles',
            'Estado',
            'Fecha Creación',
        ];
    }
}
