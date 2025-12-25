@section('tituloPagina', 'Ticket')

@section('anchoPantalla', '100%')

<div class="g_gap_pagina">
    <div class="g_panel cabecera_titulo_pagina">
        <h2>Ticket</h2>

        <div class="cabecera_titulo_botones">
            <a href="{{ route('admin.ticket.vista.todo') }}" class="g_boton g_boton_light">
                Inicio <i class="fa-solid fa-house"></i></a>

            <a href="{{ route('admin.ticket.vista.crear') }}" class="g_boton g_boton_primary">
                Crear <i class="fa-solid fa-square-plus"></i></a>

            <button wire:click="resetFiltros" class="g_boton g_boton_danger">
                Limpiar Filtros <i class="fa-solid fa-rotate-left"></i>
            </button>
        </div>
    </div>

    <div class="g_panel">
        <div class="formulario">
            <div class="g_fila">
                <div class="g_margin_bottom_10 g_columna_2">
                    <label>Cliente/DNI/Nombres</label>
                    <input type="text" wire:model.live.debounce.1300ms="buscar" id="buscar" name="buscar">
                </div>

                <div class="g_margin_bottom_10 g_columna_2">
                    <label>Area </label>
                    <select wire:model.live="area">
                        <option value="">Todos</option>
                        @foreach ($areas as $item)
                        <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="g_margin_bottom_10 g_columna_2">
                    <label>Solicitud </label>
                    <select wire:model.live="solicitud">
                        <option value="">Todos</option>
                        @foreach ($solicitudes as $item)
                        <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="g_margin_bottom_10 g_columna_2">
                    <label>Canal </label>
                    <select wire:model.live="canal">
                        <option value="">Todos</option>
                        @foreach ($canales as $item)
                        <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="g_margin_bottom_10 g_columna_2">
                    <label>Estado </label>
                    <select wire:model.live="estado">
                        <option value="">Todos</option>
                        @foreach ($estados as $estadoItem)
                        <option value="{{ $estadoItem->id }}">{{ $estadoItem->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="g_fila">
                <div class="g_margin_bottom_10 g_columna_2">
                    <label>Asignado </label>
                    <select wire:model.live="admin">
                        <option value="">Todos</option>
                        @foreach ($usuarios_admin as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="g_margin_bottom_10 g_columna_2">
                    <label>Prioridad</label>
                    <select wire:model.live="prioridad">
                        <option value="">Todos</option>
                        @foreach ($prioridades as $item)
                        <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="g_margin_bottom_10 g_columna_2">
                    <label>Derivados</label>
                    <select wire:model.live="con_derivados">
                        <option value="">Todos</option>
                        <option value="1">Con derivados</option>
                        <option value="0">Sin derivados</option>
                    </select>
                </div>

                <div class="g_margin_bottom_10 g_columna_2">
                    <label>Fecha inicio</label>
                    <input type="date" wire:model.live="fecha_inicio">
                </div>

                <div class="g_margin_bottom_10 g_columna_2">
                    <label>Fecha fin</label>
                    <input type="date" wire:model.live="fecha_fin">
                </div>
            </div>
        </div>

        <div class="tabla_contenido g_margin_bottom_20">
            <div class="contenedor_tabla">
                <table class="tabla">
                    <thead>
                        <tr>
                            <th>Ticket</th>
                            <th>Cliente</th>
                            <th>Area</th>
                            <th>Solicitud</th>
                            <th>Canal</th>
                            <th>Estado</th>
                            <th>Asignado</th>
                            <th>Prioridad</th>
                            <th>Fecha</th>
                            <th>Derivado</th>
                            <th></th>
                        </tr>
                    </thead>

                    @if ($tickets->count())
                    <tbody>
                        @foreach ($tickets as $index => $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td class="g_negrita g_resumir">{{ $item->cliente->name }}</td>
                            <td>{{ $item->area->nombre }}</td>
                            <td class="g_resumir g_inferior">{{ $item->tipoSolicitud->nombre }}</td>
                            <td>{{ $item->canal->nombre }}</td>
                            <td>
                                <span style="color: {{ $item->estado->color }};">
                                    <i class="{{ $item->estado->icono }}"></i> {{$item->estado->nombre }}
                                </span>
                            </td>
                            <td class="g_negrita g_resumir">{{ $item->asignado->name }}</td>
                            <td>
                                <span class="g_boton"
                                    style="background-color: {{ $item->prioridad->color }}; color: white;">
                                    <i class="{{ $item->prioridad->icono }}"></i> {{$item->prioridad->nombre }}
                                </span>
                            </td>

                            <td>{{ $item->created_at }}</td>

                            <td>
                                @if($item->tiene_derivados)
                                <span class="g_boton g_boton_danger">Sí</span>
                                @else
                                <span class="g_boton g_boton_light">No</span>
                                @endif
                            </td>

                            <td class="centrar_iconos">
                                <a href="{{ route('admin.ticket.vista.editar', $item->id) }}" class="g_accion_editar">
                                    <span><i class="fa-solid fa-pencil"></i></span>
                                </a>
                                <a href="{{ route('admin.ticket.vista.derivado', $item->id) }}" class="g_accion_ver">
                                    <span><i class="fa-solid fa-arrow-right-arrow-left"></i></span>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    @endif
                </table>
            </div>
        </div>

        @if ($tickets->hasPages())
        <div class="g_paginacion">
            {{ $tickets->links('vendor.pagination.default-livewire') }}
        </div>
        @endif

        @if ($tickets->count() == 0)
        <div class="g_vacio">
            <p>No hay tickets disponibles.</p>
            <i class="fa-regular fa-face-grin-wink"></i>
        </div>
        @endif
    </div>
</div>
