@section('tituloPagina', 'Crear ticket')
@section('anchoPantalla', '100%')

<div class="g_gap_pagina">
    <div class="g_panel cabecera_titulo_pagina">
        <h2>Crear cita
            @if ($ticketId)
                asociado al ticket #{{ $ticketId }}
            @endif
        </h2>

        <div class="cabecera_titulo_botones">
            <a href="{{ route('admin.cita.vista.todo') }}" class="g_boton g_boton_light">
                Inicio <i class="fa-solid fa-house"></i>
            </a>

            <a href="{{ route('admin.cita.vista.todo') }}" class="g_boton g_boton_darkt">
                <i class="fa-solid fa-arrow-left"></i> Regresar
            </a>
        </div>
    </div>

    <div class="formulario">
        <div class="g_fila">
            <div class="g_columna_8 g_gap_pagina">
                <div class="g_panel">
                    <h4 class="g_panel_titulo">General</h4>

                    <div class="g_fila">
                        <div class="g_margin_bottom_10 g_columna_6">
                            <label for="sede_id">
                                Sede <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span>
                            </label>
                            <select id="sede_id" wire:model.live="sede_id" required>
                                <option value="" selected disabled>Seleccionar una sede</option>
                                @foreach ($sedes as $sede)
                                    <option value="{{ $sede->id }}">{{ $sede->nombre }}</option>
                                @endforeach
                            </select>
                            @error('sede_id')
                                <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="g_margin_bottom_10 g_columna_6">
                            <label for="motivo_cita_id">
                                Motivo <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span>
                            </label>
                            <select id="motivo_cita_id" wire:model.live="motivo_cita_id" required>
                                <option value="" selected disabled>Seleccionar un motivo</option>
                                @foreach ($motivos as $motivo)
                                    <option value="{{ $motivo->id }}">{{ $motivo->nombre }}</option>
                                @endforeach
                            </select>
                            @error('motivo_cita_id')
                                <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="g_fila">
                        <div class="g_margin_bottom_10 g_columna_6">
                            <label for="usuario_crea_id">
                                Creador <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span>
                            </label>
                            <select id="usuario_crea_id" wire:model.live="usuario_crea_id" required>
                                <option value="" selected disabled>Seleccionar un asignado</option>
                                @foreach ($usuarios_admin as $usuario)
                                    <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                                @endforeach
                            </select>
                            @error('usuario_crea_id')
                                <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="g_margin_bottom_10 g_columna_6">
                            <label for="estado_cita_id">Estado<span class="obligatorio"><i
                                        class="fa-solid fa-asterisk"></i></span></label>
                            <select id="estado_cita_id" wire:model.live="estado_cita_id" required>
                                <option value="" selected disabled>Seleccionar un estado</option>
                                @foreach ($estados as $estado)
                                    <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                                @endforeach
                            </select>
                            @error('estado_cita_id')
                                <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="g_fila">
                        <div class="g_margin_bottom_10 g_columna_6">
                            <label for="fecha_inicio">Fecha inicio <span class="obligatorio"><i
                                        class="fa-solid fa-asterisk"></i></span></label>
                            <input type="datetime-local" id="fecha_inicio" wire:model.live="fecha_inicio" required>
                            @error('fecha_inicio')
                                <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="g_margin_bottom_10 g_columna_6">
                            <label for="fecha_fin">Fecha fin <span class="obligatorio"><i
                                        class="fa-solid fa-asterisk"></i></span></label>
                            <input type="datetime-local" id="fecha_fin" wire:model.live="fecha_fin" required>
                            @error('fecha_fin')
                                <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="g_fila">
                        <div class="g_columna_12">
                            <label for="asunto_solicitud">Asunto <span class="obligatorio"><i
                                        class="fa-solid fa-asterisk"></i></span></label>
                            <textarea id="asunto_solicitud" wire:model.live="asunto_solicitud" rows="4"></textarea>
                            @error('asunto_solicitud')
                                <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="g_fila">
                        <div class="g_columna_12">
                            <label for="descripcion_solicitud">Descripción <span class="obligatorio"><i
                                        class="fa-solid fa-asterisk"></i></span></label>
                            <textarea id="descripcion_solicitud" wire:model.live="descripcion_solicitud" rows="10"></textarea>
                            @error('descripcion_solicitud')
                                <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="g_columna_4 g_gap_pagina g_columna_invertir">
                <div class="g_panel">
                    <h4 class="g_panel_titulo">Ticket</h4>

                    <div class="g_fila">
                        <div class="g_margin_bottom_10 g_columna_6">
                            <label>Empresa</label>
                            <input type="text" disabled
                                value="{{ $ticket->unidadNegocio->nombre ?? 'Sin asignar' }}">
                        </div>

                        <div class="g_margin_bottom_10 g_columna_6">
                            <label>Proyecto</label>
                            <input type="text" disabled value="{{ $ticket->proyecto->nombre ?? 'Sin asignar' }}">
                        </div>


                    </div>

                    <div class="g_fila">
                        <div class="g_margin_bottom_10 g_columna_6">
                            <label>Área origen</label>
                            <input type="text" disabled value="{{ $ticket->area->nombre ?? 'Sin asignar' }}">
                        </div>

                        <div class="g_margin_bottom_10 g_columna_6">
                            <label>Tipo solicitud</label>
                            <input type="text" disabled
                                value="{{ $ticket->tipoSolicitud->nombre ?? 'Sin asignar' }}">
                        </div>
                    </div>

                    <div class="g_fila">
                        <div class="g_margin_bottom_10 g_columna_6">
                            <label>Sub tipo solicitud</label>
                            <input type="text" disabled
                                value="{{ $ticket->subTipoSolicitud->nombre ?? 'Sin asignar' }}">
                        </div>

                        <div class="g_margin_bottom_10 g_columna_6">
                            <label>Canal</label>
                            <input type="text" disabled value="{{ $ticket->canal->nombre ?? 'Sin asignar' }}">
                        </div>
                    </div>
                    <div class="g_fila">
                        <div class="g_margin_bottom_10 g_columna_6">
                            <label>Cliente</label>
                            <input type="text" disabled value="{{ $ticket->nombres ?? 'Sin asignar' }}">
                        </div>

                        <div class="g_margin_bottom_10 g_columna_6">
                            <label for="usuario_asignado_id">
                                Asignado <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span>
                            </label>
                            <input type="text" disabled value="{{ $ticket->asignado->name ?? 'Sin asignar' }}">
                        </div>
                    </div>
                    <div class="g_fila">
                        <div class="g_columna_12">
                            <label>Asunto </label>
                            <textarea disabled>{{ $ticket->asunto_inicial ?? 'Sin asunto' }}</textarea>
                        </div>
                    </div>

                    <div class="g_fila">
                        <div class="g_columna_12">
                            <label>Descripción </label>
                            <textarea disabled>{{ $ticket->descripcion_inicial ?? 'Sin descripción' }}</textarea>
                        </div>
                    </div>

                    @if (!empty($ticket->lotes))
                        <div class="g_fila">
                            <div class="g_columna_12">
                                <label>Lotes</label>

                                <table class="tabla_eliminar">
                                    <thead>
                                        <tr>
                                            <th>Razón Social</th>
                                            <th>Proyecto</th>
                                            <th>Mz./Lt.</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ticket->lotes as $index => $l)
                                            <tr class="sorteable_item" wire:key="lote-{{ $index }}">
                                                <td> {{ $l['razon_social'] }} </td>
                                                <td> {{ $l['proyecto'] }} </td>
                                                <td> {{ $l['numero_lote'] }} </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="g_margin_top_20">
            <div class="formulario_botones">
                <button wire:click="store" class="guardar" wire:loading.attr="disabled">Guardar</button>

                <a href="{{ route('admin.cita.vista.todo') }}" class="cancelar">Cancelar</a>
            </div>
        </div>
    </div>
