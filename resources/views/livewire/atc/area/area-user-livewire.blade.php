@section('tituloPagina', 'Area admin')
@section('anchoPantalla', '100%')

<div class="g_gap_pagina">
    <div class="g_panel cabecera_titulo_pagina">
        <div>
            <h2>Área: {{ $area->nombre }}</h2>
        </div>

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

                <div class="tabla_contenido g_margin_bottom_20">
                    <table class="tabla">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Acción</th>
                            </tr>
                        </thead>

                        @if ($usuariosAgregados->count())
                            <tbody>
                                @foreach ($usuariosAgregados as $index => $user)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td class="g_resaltar">{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>

                                        <td class="centrar_iconos">
                                            <button wire:click="quitarUsuario({{ $user->id }})"
                                                class="g_boton g_boton_danger">
                                                Quitar
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        @endif
                    </table>
                </div>               

                @if ($usuariosAgregados->count() == 0)
                    <div class="g_vacio">
                        <p>No hay usuarios asignados.</p>
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

                <div class="tabla_contenido g_margin_bottom_20">
                    <table class="tabla">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Acción</th>
                            </tr>
                        </thead>

                        @if ($usuariosDisponibles->count())
                            <tbody>
                                @foreach ($usuariosDisponibles as $index => $user)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td class="g_resaltar">{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>

                                        <td class="centrar_iconos">
                                            <button wire:click="agregarUsuario({{ $user->id }})"
                                                class="g_boton g_boton_primary">
                                                Agregar
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        @endif
                    </table>
                </div>

                @if ($usuariosDisponibles->hasPages())
                    <div class="g_paginacion">
                        {{ $usuariosDisponibles->links('vendor.pagination.default-livewire') }}
                    </div>
                @endif

                @if ($usuariosDisponibles->count() == 0)
                    <div class="g_vacio">
                        <p>No hay usuarios disponibles.</p>
                        <i class="fa-regular fa-face-grin-wink"></i>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
