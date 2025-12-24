@section('tituloPagina', 'Admins')

@section('anchoPantalla', '100%')

<div class="g_gap_pagina">
    <div class="g_panel cabecera_titulo_pagina">
        <h2>Admins</h2>

        <div class="cabecera_titulo_botones">
            <a href="{{ route('admin.usuario.vista.todo') }}" class="g_boton g_boton_light">
                Inicio <i class="fa-solid fa-house"></i></a>

            <a href="{{ route('admin.usuario.vista.crear') }}" class="g_boton g_boton_primary">
                Crear <i class="fa-solid fa-square-plus"></i></a>

            <button wire:click="resetFiltros" class="g_boton g_boton_danger">
                Limpiar Filtros <i class="fa-solid fa-rotate-left"></i>
            </button>
        </div>
    </div>

    <div class="g_panel">
        <div class="tabla_cabecera">
            <div class="tabla_cabecera_botones">
                <button>
                    PDF <i class="fa-solid fa-file-pdf"></i>
                </button>

                <button>
                    EXCEL <i class="fa-regular fa-file-excel"></i>
                </button>
            </div>

            <div class="tabla_cabecera_buscar">
                <form action="">
                    <input type="text" wire:model.live.debounce.1300ms="buscar" id="buscar" name="buscar"
                        placeholder="Buscar...">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </form>
            </div>
        </div>

        <div class="tabla_contenido">
            <div class="contenedor_tabla">
                <table class="tabla">
                    <thead>
                        <tr>
                            <th>Nº</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Fecha Creación</th>
                            <th>Activo</th>
                            <th></th>
                        </tr>
                    </thead>

                    @if ($items->count())
                    <tbody>
                        @foreach ($items as $index => $item)
                        <tr>
                            <td>{{ $items->firstItem() + $index }}</td>
                            <td class="g_resaltar">{{ $item->name }}</td>
                            <td class="g_resaltar">{{ $item->email }}</td>
                            <td class="g_resaltar">{{ $item->rol }}</td>
                            <td class="g_resaltar">{{ $item->created_at }}</td>
                            <td>
                                <span class="g_estado {{ $item->activo ? 'g_activo' : 'g_desactivado' }}"><i
                                        class="fa-solid fa-circle"></i></span>
                                {{ $item->activo ? 'Activo' : 'Desactivo' }}
                            </td>
                            <td class="centrar_iconos">
                                <a href="{{ route('admin.usuario.vista.editar', $item) }}" class="g_accion_editar">
                                    <span><i class="fa-solid fa-pencil"></i></span>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    @endif
                </table>
            </div>
        </div>

        @if ($items->hasPages())
        <div class="g_paginacion">
            {{ $items->links('vendor.pagination.default-livewire') }}
        </div>
        @endif

        @if ($items->count() == 0)
        <div class="g_vacio">
            <p>No hay items disponibles.</p>
            <i class="fa-regular fa-face-grin-wink"></i>
        </div>
        @endif

    </div>
</div>