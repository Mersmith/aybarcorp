@section('tituloPagina', 'Editar cita')
@section('anchoPantalla', '100%')

<div class="g_gap_pagina">

    <div class="g_panel cabecera_titulo_pagina">
        <h2>Editar cita @if ($ticket)
                asociado al ticket
                <a href="{{ route('admin.ticket.vista.editar', $ticket->id) }}">#{{ $ticket->id }}</a>
            @endif
        </h2>

        <div class="cabecera_titulo_botones">
            <a href="{{ route('admin.cita.vista.todo') }}" class="g_boton g_boton_light">
                Inicio <i class="fa-solid fa-house"></i>
            </a>

            <button type="button" class="g_boton g_boton_danger" onclick="alertaEliminarCita()">
                Eliminar <i class="fa-solid fa-trash-can"></i>
            </button>

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
                            <label>Sede</label>
                            <input type="text" disabled value="{{ $cita->sede->nombre ?? 'Sin asignar' }}">
                        </div>

                        <div class="g_margin_bottom_10 g_columna_6">
                            <label>Motivo</label>
                            <input type="text" disabled value="{{ $cita->motivo->nombre ?? 'Sin asignar' }}">
                        </div>
                    </div>

                    <div class="g_fila">
                        <div class="g_margin_bottom_10 g_columna_6">
                            <label>Admin</label>
                            <input type="text" disabled value="{{ $cita->crea->name ?? 'Sin asignar' }}">
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
                            <label>Fecha inicio</label>
                            <input type="text" disabled value="{{ $cita->fecha_inicio ?? 'Sin asignar' }}">
                        </div>

                        <div class="g_margin_bottom_10 g_columna_6">
                            <label>Fecha fin</label>
                            <input type="text" disabled value="{{ $cita->fecha_fin ?? 'Sin asignar' }}">
                        </div>
                    </div>

                    <div class="g_fila">
                        <div class="g_columna_12">
                            <label>Asunto</label>
                            <textarea disabled rows="3">{{ $cita->asunto_solicitud ?? 'Sin asunto' }}</textarea>
                        </div>
                    </div>

                    <div class="g_fila">
                        <div class="g_columna_12">
                            <label>Descripción</label>
                            <textarea disabled rows="4">{{ $cita->descripcion_solicitud ?? 'Sin asunto' }}</textarea>
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
                <button wire:click="store" class="guardar" wire:loading.attr="disabled" wire:target="store">
                    <span wire:loading.remove wire:target="store">Actualizar</span>
                    <span wire:loading wire:target="store">Actualizando...</span>
                </button>

                <a href="{{ route('admin.canal.vista.todo') }}" class="cancelar">Cancelar</a>
            </div>
        </div>
    </div>

    <script>
        function alertaEliminarCita() {
            Swal.fire({
                title: '¿Quieres eliminar?',
                text: "No podrás recuperarlo.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Sí, eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('eliminarCitaOn');

                    Swal.fire(
                        '¡Eliminado!',
                        'Eliminaste correctamente.',
                        'success'
                    )
                }
            });
        }
    </script>
</div>
