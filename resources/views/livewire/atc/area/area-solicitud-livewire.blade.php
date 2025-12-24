<div>
    <div class="g_panel cabecera_titulo_pagina">
        <h2>Área: {{ $area->nombre }}</h2>

        <div class="cabecera_titulo_botones">
            <a href="{{ route('admin.area.vista.todo') }}" class="g_boton g_boton_light">
                Inicio <i class="fa-solid fa-house"></i></a>

            <a href="{{ route('admin.area.vista.crear') }}" class="g_boton g_boton_primary">
                Crear <i class="fa-solid fa-square-plus"></i></a>

            <a href="{{ route('admin.area.vista.editar', $area->id) }}" class="g_boton g_boton_secondary">
                Editar <i class="fa-solid fa-pencil"></i></a>

            <a href="{{ route('admin.area.vista.todo') }}" class="g_boton g_boton_darkt">
                <i class="fa-solid fa-arrow-left"></i> Regresar</a>
        </div>
    </div>

    <div class="g_fila g_margin_top_20">
        <!-- AGREGADOS -->
        <div class="g_columna_6">
            <div class="g_panel">
                <h4 class="g_panel_titulo">Asignados</h4>

                <div class="tabla_cabecera">
                    <div class="tabla_cabecera_buscar">
                        <form action="">
                            <input type="text" wire:model.live.debounce.1300ms="searchAgregados"
                                placeholder="Buscar...">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </form>

                    </div>
                </div>

                @if ($tiposAgregados->count())
                    <div class="tabla_contenido g_margin_bottom_20">
                        <table class="tabla">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tipo de Solicitud</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tiposAgregados as $index => $tipo)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td class="g_resaltar">{{ $tipo->nombre }}</td>

                                        <td class="centrar_iconos">
                                            <button wire:click="quitarTipo({{ $tipo->id }})"
                                                class="g_boton g_boton_danger">
                                                Quitar
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="g_vacio">
                        <p>No hay tipos asignados.</p>
                        <i class="fa-regular fa-face-grin-wink"></i>
                    </div>
                @endif
            </div>
        </div>

        <!-- DISPONIBLES -->
        <div class="g_columna_6">
            <div class="g_panel">
                <h4 class="g_panel_titulo">Disponibles</h4>

                <div class="tabla_cabecera">
                    <div class="tabla_cabecera_buscar">
                        <form action="">
                            <input type="text" wire:model.live.debounce.1300ms="searchDisponibles"
                                placeholder="Buscar...">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </form>

                    </div>
                </div>

                @if ($tiposDisponibles->count())
                    <div class="tabla_contenido g_margin_bottom_20">
                        <table class="tabla">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tipo de Solicitud</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tiposDisponibles as $index => $tipo)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td class="g_resaltar">{{ $tipo->nombre }}</td>

                                        <td class="centrar_iconos">
                                            <button wire:click="agregarTipo({{ $tipo->id }})"
                                                class="g_boton g_boton_primary">
                                                Agregar
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $tiposDisponibles->links() }}
                @else
                    <div class="g_vacio">
                        <p>No hay tipos disponibles.</p>
                        <i class="fa-regular fa-face-grin-wink"></i>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
