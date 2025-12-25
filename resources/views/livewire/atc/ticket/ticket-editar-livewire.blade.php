@section('tituloPagina', 'Editar ticket')
@section('anchoPantalla', '100%')

<div class="g_gap_pagina">
    <!-- CABECERA -->
    <div class="g_panel cabecera_titulo_pagina">
        <h2>Editar ticket</h2>

        <div class="cabecera_titulo_botones">
            <a href="{{ route('admin.ticket.vista.todo') }}" class="g_boton g_boton_light">
                Inicio <i class="fa-solid fa-house"></i>
            </a>

            <a href="{{ route('admin.ticket.vista.crear') }}" class="g_boton g_boton_primary">
                Crear <i class="fa-solid fa-square-plus"></i></a>

            <button type="button" class="g_boton g_boton_danger" onclick="alertaEliminarTicket()">
                Eliminar <i class="fa-solid fa-trash-can"></i>
            </button>

            <a href="{{ route('admin.ticket.vista.derivado', $ticket->id) }}" class="g_boton g_boton_warning">
                Derivar <i class="fa-solid fa-arrow-right-arrow-left"></i></a>

            <a href="{{ route('admin.ticket.vista.todo') }}" class="g_boton g_boton_darkt">
                <i class="fa-solid fa-arrow-left"></i> Regresar
            </a>
        </div>
    </div>

    <!-- FORMULARIO -->
    <div class="formulario">
        <div class="g_fila">
            <!-- IZQUIERDA -->
            <div class="g_columna_8 g_gap_pagina">
                <div class="g_panel">
                    <h4 class="g_panel_titulo">General</h4>

                    <div class="g_fila">
                        <div class="g_margin_bottom_10 g_columna_4">
                            <label>Área origen</label>
                            <input type="text" disabled value="{{ $ticket->area->nombre ?? 'Sin asignar' }}">
                        </div>

                        <div class="g_margin_bottom_10 g_columna_4">
                            <label>Tipo solicitud</label>
                            <input type="text" disabled value="{{ $ticket->tipoSolicitud->nombre ?? 'Sin asignar' }}">
                        </div>

                        <div class="g_margin_bottom_10 g_columna_4">
                            <label>Canal</label>
                            <input type="text" disabled value="{{ $ticket->canal->nombre ?? 'Sin asignar' }}">
                        </div>
                    </div>

                    <div class="g_fila">
                        <div class="g_margin_bottom_10 g_columna_4">
                            <label>Cliente</label>
                            <input type="text" disabled value="{{ $ticket->cliente->name ?? 'Sin asignar' }}">
                        </div>

                        <div class="g_margin_bottom_10 g_columna_4">
                            <label for="estado_ticket_id">
                                Estado <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span>
                            </label>
                            <select id="estado_ticket_id" wire:model.live="estado_ticket_id" required>
                                <option value="" selected disabled>Seleccionar un estado</option>
                                @foreach ($estados as $estado)
                                <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                                @endforeach
                            </select>
                            @error('estado_ticket_id')
                            <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="g_margin_bottom_10 g_columna_4">
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
                                        <th>Mz.</th>
                                        <th>Lot.</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ticket->lotes as $index => $l)
                                    <tr class="sorteable_item" wire:key="lote-{{ $index }}">
                                        <td> {{ $l['razon_social'] }} </td>
                                        <td> {{ $l['descripcion'] }} </td>
                                        <td> {{ $l['id_manzana'] }} </td>
                                        <td> {{ $l['id_lote'] }} </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="g_panel">
                    <h4 class="g_panel_titulo">Detalle</h4>
                    <div class="g_fila">
                        <div class="g_columna_12">
                            <label for="asunto">Asunto <span class="obligatorio"><i
                                        class="fa-solid fa-asterisk"></i></span></label>
                            <textarea id="asunto" wire:model.live="asunto" rows="2"></textarea>
                            @error('asunto')
                            <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="g_fila">
                        <div class="g_columna_12">
                            <label for="descripcion">Descripción <span class="obligatorio"><i
                                        class="fa-solid fa-asterisk"></i></span></label>
                            <textarea id="descripcion" wire:model.live="descripcion" rows="5"></textarea>
                            @error('descripcion')
                            <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="g_margin_top_20">
                        <div class="formulario_botones">
                            <button wire:click="store" class="guardar" wire:loading.attr="disabled" wire:target="store">
                                <span wire:loading.remove wire:target="store">Actualizar</span>
                                <span wire:loading wire:target="store">Actualizando...</span>
                            </button>

                            <a href="{{ route('admin.ticket.vista.todo') }}" class="cancelar">Cancelar</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- DERECHA -->
            <div class="g_columna_4 g_gap_pagina g_columna_invertir">
                <div class="g_panel">
                    <div class="">
                        <input type="file" id="fileUpload" wire:model="archivo" accept=".docx,.xlsx,.pptx,.pdf"
                            style="display: none;">

                        <div class="contenedor_dropzone" onclick="document.getElementById('fileUpload').click()">
                            @if ($archivo)
                            <div class="dropzone_item">
                                @php
                                $ext = strtolower($archivo->getClientOriginalExtension());
                                $icons = [
                                'pdf' => 'fa-file-pdf text-red-600',
                                'docx' => 'fa-file-word text-blue-600',
                                'xlsx' => 'fa-file-excel text-green-600',
                                'pptx' => 'fa-file-powerpoint text-orange-500',
                                ];
                                @endphp

                                <i class="fa-solid {{ $icons[$ext] ?? 'fa-file text-gray-500' }}"></i>
                                <span>{{ $archivo->getClientOriginalName() }}</span>

                                <button type="button" wire:click="$set('archivo', null)" class="remove_button">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                            @else
                            <div class="g_vacio">
                                <p>Haz clic para subir archivo</p>
                            </div>
                            @endif
                        </div>

                        @error('archivo') <p class="mensaje_error">{{ $message }}</p> @enderror
                    </div>

                    @if ($archivo)
                    <div class="g_margin_top_20">
                        <label>Descripción</label>
                        <textarea wire:model="descripcion_archivo" class="g_input"></textarea>
                        @error('descripcion_archivo') <p class="mensaje_error">{{ $message }}</p> @enderror
                    </div>

                    <div class="formulario_botones g_margin_top_20">
                        <button wire:click="adjuntar" class="guardar" wire:loading.attr="disabled"
                            wire:target="adjuntar">
                            <span wire:loading.remove wire:target="adjuntar">Adjuntar</span>
                            <span wire:loading wire:target="adjuntar">Adjuntando...</span>
                        </button>

                        <button wire:click="cancelar" class="cancelar" wire:loading.attr="disabled"
                            wire:target="cancelar">
                            <span wire:loading.remove wire:target="store">Cancelar</span>
                            <span wire:loading wire:target="cancelar">Cancelando...</span>
                        </button>
                    </div>
                    @endif
                </div>

                <div class="g_panel">
                    <h4 class="g_panel_titulo">Adjuntos</h4>

                    <div class="tabla_contenido">
                        <div class="contenedor_tabla">
                            <table class="tabla">
                                <thead>
                                    <tr>
                                        <th>Descripcion</th>
                                        <th>Ext.</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($archivos_existentes as $file)
                                    <tr>
                                        <td>{{ $file->descripcion }}</td>
                                        <td>{{ $file->extension }}</td>
                                        <td class="centrar_iconos">
                                            <a href="{{ $file->url }}" class="g_accion_editar">
                                                <span><i class="fa-solid fa-eye"></i></span>
                                            </a>
                                            <button onclick="alertaEliminarArchivo({{ $file->id }})"
                                                class="g_desactivado">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="g_panel g_margin_top_20">
        <h4 class="g_panel_titulo">Historial del ticket</h4>

        <div class="tabla_contenido g_margin_bottom_20">
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
    <script>
        function alertaEliminarTicket() {
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
                    Livewire.dispatch('eliminarTicketOn');

                    Swal.fire(
                        '¡Eliminado!',
                        'Eliminaste correctamente.',
                        'success'
                    )
                }
            });
        }

        function alertaEliminarArchivo(idArchivo) {
            console.log(idArchivo);
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
                    Livewire.dispatch('eliminarArchivoOn', { id: idArchivo });

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