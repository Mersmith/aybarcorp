@section('tituloPagina', 'Clientes antiguo')

@section('anchoPantalla', '100%')

<div class="g_gap_pagina">
    <div class="g_panel cabecera_titulo_pagina">
        <h2>Clientes antiguo</h2>

        <div class="cabecera_titulo_botones">
            <a href="{{ route('admin.cliente-bd-antiguo.vista.todo') }}" class="g_boton g_boton_light">
                Inicio <i class="fa-solid fa-house"></i></a>

            <a href="{{ route('admin.cliente-bd-antiguo.vista.crear') }}" class="g_boton g_boton_primary">
                Crear <i class="fa-solid fa-square-plus"></i></a>

            <button wire:click="resetFiltros" class="g_boton g_boton_danger">
                Limpiar Filtros <i class="fa-solid fa-rotate-left"></i>
            </button>
        </div>
    </div>

    <div class="g_panel">
        <div class="formulario">
            <div class="g_fila">
                <div class="g_margin_bottom_10 g_columna_4">
                    <label>Cliente/Nombres/Dni</label>
                    <input type="text" wire:model.live.debounce.1300ms="buscar" id="buscar" name="buscar">
                </div>

                <div class="g_margin_bottom_10 g_columna_4">
                    <label>Cliente/Codigo</label>
                    <input type="text" wire:model.live.debounce.1300ms="codigo_cliente" id="codigo_cliente"
                        name="codigo_cliente">
                </div>
            </div>
        </div>

        <div class="tabla_contenido">
            <div class="contenedor_tabla">
                <table class="tabla">
                    <thead>
                        <tr>
                            <th>Nº</th>
                            <th>Razón Social</th>
                            <th>Codigo Cliente</th>
                            <th>Nombre</th>
                            <th>Proyecto</th>
                            <th>Etapa</th>
                            <th>Número Lote</th>
                            <th>DNI</th>
                            <th></th>
                        </tr>
                    </thead>

                    @if ($items->count())
                        <tbody>
                            @foreach ($items as $index => $item)
                                <tr>
                                    <td>{{ $items->firstItem() + $index }}</td>
                                    <td class="g_resaltar">{{ $item->razon_social }}</td>
                                    <td class="g_resaltar">{{ $item->codigo_cliente }}</td>
                                    <td class="g_resaltar">{{ $item->nombre }}</td>
                                    <td class="g_resaltar">{{ $item->proyecto }}</td>
                                    <td class="g_resaltar">{{ $item->etapa }}</td>
                                    <td class="g_resaltar">{{ $item->numero_lote }}</td>
                                    <td class="g_resaltar">{{ $item->dni }}</td>
                                    <td class="centrar_iconos">
                                        <a href="{{ route('admin.cliente-bd-antiguo.vista.editar', $item->id) }}"
                                            class="g_accion_editar">
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
