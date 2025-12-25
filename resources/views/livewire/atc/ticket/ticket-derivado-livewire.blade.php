@section('tituloPagina', 'Derivar ticket')
@section('anchoPantalla', '100%')

<div class="g_gap_pagina">
    <div class="g_panel cabecera_titulo_pagina">
        <h2>Derivar ticket</h2>

        <div class="cabecera_titulo_botones">
            <a href="{{ route('admin.ticket.vista.todo') }}" class="g_boton g_boton_light">
                Inicio <i class="fa-solid fa-house"></i>
            </a>

            <a href="{{ route('admin.ticket.vista.crear') }}" class="g_boton g_boton_primary">
                Crear <i class="fa-solid fa-square-plus"></i></a>

            <a href="{{ route('admin.ticket.vista.editar', $ticket->id) }}" class="g_boton g_boton_secondary">
                Editar <i class="fa-solid fa-pencil"></i></a>

            <a href="{{ route('admin.ticket.vista.todo') }}" class="g_boton g_boton_darkt">
                <i class="fa-solid fa-arrow-left"></i> Regresar
            </a>
        </div>
    </div>

    <div class="formulario">
        <div class="g_fila">
            <div class="g_columna_8 g_gap_pagina">
                <div class="g_panel">
                    <h4 class="g_panel_titulo">Derivación</h4>

                    <div class="g_fila">
                        <div class="g_columna_6 g_margin_bottom_10">
                            <label>Área origen</label>
                            <input type="text" disabled value="{{ $ticket->area->nombre ?? 'Sin asignar' }}">
                        </div>

                        <div class="g_columna_6 g_margin_bottom_10">
                            <label>Usuario origen</label>
                            <input type="text" disabled value="{{ $ticket->asignado->name ?? 'Sin asignar' }}">
                        </div>
                    </div>

                    <div class="g_fila">
                        <div class="g_columna_6 g_margin_bottom_10">
                            <label for="a_area_id">Área destino <span class="obligatorio"><i
                                        class="fa-solid fa-asterisk"></i></span></label>
                            <select id="a_area_id" wire:model.live="a_area_id" required>
                                <option value="" selected disabled>Seleccionar área destino</option>
                                @foreach ($areas as $area)
                                <option value="{{ $area->id }}">{{ $area->nombre }}</option>
                                @endforeach
                            </select>
                            @error('a_area_id') <p class="mensaje_error">{{ $message }}</p> @enderror
                        </div>

                        <div class="g_columna_6 g_margin_bottom_10">
                            <label for="usuario_recibe_id">Usuario destino</label>
                            <select id="usuario_recibe_id" wire:model.live="usuario_recibe_id">
                                <option value="">Sin asignar</option>
                                @foreach ($usuarios as $usuario)
                                <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                                @endforeach
                            </select>
                            @error('usuario_recibe_id') <p class="mensaje_error">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="g_fila">
                        <div class="g_columna_12">
                            <label for="motivo">Motivo</label>
                            <textarea id="motivo" wire:model.live="motivo" rows="4"></textarea>
                            @error('motivo') <p class="mensaje_error">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="g_margin_top_20">
                        <div class="formulario_botones">
                            <button wire:click="derivar" class="guardar" wire:loading.attr="disabled"
                                wire:target="derivar">
                                <span wire:loading.remove wire:target="derivar">Derivar</span>
                                <span wire:loading wire:target="derivar">Derivando...</span>
                            </button>

                            <a href="{{ route('admin.ticket.vista.todo') }}" class="cancelar">Cancelar</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel derecho: Derivaciones previas -->
            <div class="g_columna_4 g_gap_pagina g_columna_invertir">

                <div class="g_panel">
                    <h4 class="g_panel_titulo">Ticket: {{ $ticket->id}}</h4>

                    <div class="g_columna_12 g_margin_bottom_10">
                        <label>Cliente</label>
                        <input type="text" disabled value="{{ $ticket->cliente->name ?? 'Sin asignar' }}">
                    </div>

                    <div class="g_columna_12 g_margin_bottom_10">
                        <label>Asunto </label>
                        <textarea disabled>{{ $ticket->asunto_inicial ?? 'Sin asunto' }}</textarea>
                    </div>

                    <div class="g_columna_12">
                        <label>Asunto </label>
                        <textarea disabled>{{ $ticket->descripcion_inicial ?? 'Sin descripción' }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="g_panel">
        <h4 class="g_panel_titulo">Derivaciones previas</h4>

        <div class="tabla_contenido">
            <div class="contenedor_tabla">
                <table class="tabla">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>De</th>
                            <th>A</th>
                            <th>Recibe</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($derivaciones as $d)
                        <tr>
                            <td>{{ $d->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $d->deArea->nombre ?? 'Sin asignar' }}</td>
                            <td>{{ $d->aArea->nombre ?? 'Sin asignar' }}</td>
                            <td>{{ $d->usuarioDeriva->name ?? ($d->usuarioRecibe->name ?? 'Sistema') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4">No hay derivaciones</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="g_panel ">
        <h4 class="g_panel_titulo">Historial del ticket</h4>

        <div class="tabla_contenido">
            <div class="contenedor_tabla">
                <table class="tabla">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Usuario</th>
                            <th>Acción</th>
                            <th>Detalle</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($historial as $item)
                        <tr>
                            <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $item->usuario->name ?? 'Sistema' }}</td>
                            <td>{{ $item->accion }}</td>
                            <td>
                                @foreach (explode(' | ', $item->detalle) as $linea)
                                <div>{{ $linea }}</div>
                                @endforeach
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>