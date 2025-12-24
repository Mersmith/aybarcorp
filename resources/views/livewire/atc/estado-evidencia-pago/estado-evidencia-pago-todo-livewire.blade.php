@section('tituloPagina', 'Estados comprobante pago')

@section('anchoPantalla', '100%')

<div class="g_gap_pagina">
    <div class="g_panel cabecera_titulo_pagina">
        <h2>Estados comprobante pago</h2>

        <div class="cabecera_titulo_botones">
            <a href="{{ route('admin.estado-comprobante-pago.vista.todo') }}" class="g_boton g_boton_light">
                Inicio <i class="fa-solid fa-house"></i></a>

            <a href="{{ route('admin.estado-comprobante-pago.vista.crear') }}" class="g_boton g_boton_primary">
                Crear <i class="fa-solid fa-square-plus"></i></a>
        </div>
    </div>

    <div class="g_panel">
        <div class="tabla_cabecera">
            <div class="tabla_cabecera_buscar">
                <form action="">
                    <input type="text" wire:model.live.debounce.1300ms="buscar" id="buscar" name="buscar"
                        placeholder="Buscar...">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </form>
            </div>
        </div>

        <div class="tabla_contenido g_margin_bottom_20">
            <div class="contenedor_tabla">
                <table class="tabla">
                    <thead>
                        <tr>
                            <th>Nº</th>
                            <th>Nombre</th>
                            <th>Color</th>
                            <th>Icono</th>
                            <th>Estado</th>
                            <th></th>
                        </tr>
                    </thead>

                    @if ($estados->count())
                    <tbody>
                        @foreach ($estados as $index => $item)
                        <tr>
                            <td> {{ $index + 1 }} </td>
                            <td class="g_resaltar">{{ $item->nombre }}</td>
                            <td class="g_resaltar">
                                @if ($item->color)
                                <span style="color: {{ $item->color }};">
                                    <i class="fa-solid fa-circle"></i>
                                </span>
                                @endif
                            </td>
                            <td class="g_resaltar"><i class="{{ $item->icono }}"></i></td>

                            <td>
                                <span class="g_estado {{ $item->activo ? 'g_activo' : 'g_desactivado' }}"><i
                                        class="fa-solid fa-circle"></i></span>
                                {{ $item->activo ? 'Activo' : 'Desactivo' }}
                            </td>

                            <td class="centrar_iconos">
                                <a href="{{ route('admin.estado-comprobante-pago.vista.editar', $item->id) }}"
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

        @if ($estados->hasPages())
        <div class="g_paginacion">
            {{ $estados->links('vendor.pagination.default-livewire') }}
        </div>
        @endif

        @if ($estados->count() == 0)
        <div class="g_vacio">
            <p>No hay estados disponibles.</p>
            <i class="fa-regular fa-face-grin-wink"></i>
        </div>
        @endif
    </div>
</div>