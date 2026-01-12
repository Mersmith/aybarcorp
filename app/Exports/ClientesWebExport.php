<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ClientesWebExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected string $buscar;
    protected string $email;
    protected string $activo;
    protected string $verificado;
    protected string $tratamiento;
    protected string $politica;
    protected string $fecha_inicio;
    protected string $fecha_fin;
    protected int $perPage;
    protected int $page;

    public function __construct(string $buscar, string $email, string $activo, string $verificado, string $tratamiento, string $politica, string $fecha_inicio, string $fecha_fin, int $perPage, int $page)
    {
        $this->buscar = $buscar;
        $this->email = $email;
        $this->activo = $activo;
        $this->verificado = $verificado;
        $this->tratamiento = $tratamiento;
        $this->politica = $politica;
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_fin = $fecha_fin;
        $this->perPage = $perPage;
        $this->page = $page;
    }

    public function collection()
    {
        return User::query()
            ->where('rol', 'cliente')
            ->leftJoin('clientes', 'clientes.user_id', '=', 'users.id')
            ->where(function ($q) {
                $q->where('users.name', 'like', "%{$this->buscar}%")
                    ->orWhere('clientes.dni', 'like', "%{$this->buscar}%");
            })
            ->when(
                $this->activo !== '',
                fn($q) =>
                $q->where('users.activo', $this->activo)
            )
            ->when(
                $this->tratamiento !== '',
                fn($q) =>
                $q->where('users.politica_uno', $this->tratamiento)
            )
            ->when(
                $this->politica !== '',
                fn($q) =>
                $q->where('users.politica_dos', $this->politica)
            )
            ->when($this->verificado !== '', function ($q) {
                $this->verificado == '1'
                    ? $q->whereNotNull('users.email_verified_at')
                    : $q->whereNull('users.email_verified_at');
            })
            ->when(
                $this->fecha_inicio,
                fn($q) =>
                $q->whereDate('users.created_at', '>=', $this->fecha_inicio)
            )
            ->when(
                $this->fecha_fin,
                fn($q) =>
                $q->whereDate('users.created_at', '<=', $this->fecha_fin)
            )
            ->where('users.email', 'like', "%{$this->email}%")
            ->select(
                'users.id',
                'users.name',
                'users.email',
                'clientes.dni',
                'users.created_at',
                'users.email_verified_at',
                'users.politica_uno',
                'users.politica_dos',
                'users.activo'
            )
            ->orderByDesc('users.created_at')
            ->skip(($this->page - 1) * $this->perPage)
            ->take($this->perPage)
            ->get()
            ->map(fn($u, $index) => [
                $index + 1,
                $u->id,
                $u->name,
                $u->email,
                $u->dni ?? '-',
                $u->created_at->format('Y-m-d H:i'),
                $u->email_verified_at ? 'Sí' : 'No',
                $u->politica_uno ? 'Sí' : 'No',
                $u->politica_dos ? 'Sí' : 'No',
                $u->activo ? 'Activo' : 'Inactivo',
            ]);
    }

    public function headings(): array
    {
        return [
            'N°',
            'ID',
            'Nombre',
            'Email',
            'DNI',
            'Fecha Creación',
            'Verificado',
            'Tratamiento D.P.',
            'Política Comercial',
            'Estado',
        ];
    }
}
