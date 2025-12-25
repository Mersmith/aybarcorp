@section('tituloPagina', 'Crear ticket')
@section('anchoPantalla', '100%')

<div class="g_gap_pagina">
    <!-- CABECERA -->
    <div class="g_panel cabecera_titulo_pagina">
        <h2>Crear ticket</h2>

        <div class="cabecera_titulo_botones">
            <a href="{{ route('admin.ticket.vista.todo') }}" class="g_boton g_boton_light">
                Inicio <i class="fa-solid fa-house"></i>
            </a>

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
                            <label for="area_id">
                                Area <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span>
                            </label>
                            <select id="area_id" wire:model.live="area_id" required>
                                <option value="" selected disabled>Seleccionar un area</option>
                                @foreach ($areas as $area)
                                    <option value="{{ $area->id }}">{{ $area->nombre }}</option>
                                @endforeach
                            </select>
                            @error('area_id')
                                <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="g_margin_bottom_10 g_columna_4">
                            <label for="tipo_solicitud_id">
                                Tipo solicitud <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span>
                            </label>
                            <select id="tipo_solicitud_id" wire:model.live="tipo_solicitud_id" required>
                                <option value="" selected disabled>Seleccionar un area</option>
                                @foreach ($tipos_solicitudes as $tipo)
                                    <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                @endforeach
                            </select>
                            @error('tipo_solicitud_id')
                                <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="g_margin_bottom_10 g_columna_4">
                            <label for="canal_id">Canal <span class="obligatorio"><i
                                        class="fa-solid fa-asterisk"></i></span></label>
                            <select id="canal_id" name="canal_id" wire:model.live="canal_id" required>
                                <option value="" selected disabled>Seleccionar un canal</option>
                                @if ($canales)
                                    @foreach ($canales as $canal)
                                        <option value="{{ $canal->id }}">{{ $canal->nombre }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('canal_id')
                                <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="g_fila">
                        <div class="g_margin_bottom_10 g_columna_4">
                            <label for="cliente_id">
                                Cliente <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span>
                            </label>
                            <input type="text" disabled
                                value="{{ $existingCliente?->user->name ?? 'Sin asignar' }}">

                            @error('cliente_id')
                                <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="g_margin_bottom_10 g_columna_4">
                            <label>Estado</label>
                            <input type="text" value="Abierto" disabled>
                        </div>

                        <div class="g_margin_bottom_10 g_columna_4">
                            <label for="usuario_asignado_id">
                                Asignado <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span>
                            </label>
                            <select id="usuario_asignado_id" wire:model.live="usuario_asignado_id" required>
                                <option value="" selected disabled>Seleccionar un asignado</option>
                                @foreach ($usuarios as $usuario)
                                    <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                                @endforeach
                            </select>
                            @error('usuario_asignado_id')
                                <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="g_fila">
                        <div class="g_columna_12">
                            <label for="asunto_inicial">Asunto <span class="obligatorio"><i
                                        class="fa-solid fa-asterisk"></i></span></label>
                            <textarea id="asunto_inicial" wire:model.live="asunto_inicial" rows="2"></textarea>
                            @error('asunto_inicial')
                                <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="g_fila">
                        <div class="g_columna_12">
                            <label for="descripcion_inicial">Descripción <span class="obligatorio"><i
                                        class="fa-solid fa-asterisk"></i></span></label>
                            <textarea id="descripcion_inicial" wire:model.live="descripcion_inicial" rows="5"></textarea>
                            @error('descripcion_inicial')
                                <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                @if (!empty($lotes_agregados))
                    <div class="g_panel">
                        <h4 class="g_panel_titulo">Lotes seleccionados</h4>

                        <table class="tabla_eliminar">
                            <thead>
                                <tr>
                                    <th>Razón Social</th>
                                    <th>Proyecto</th>
                                    <th>Mz.</th>
                                    <th>Lot.</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lotes_agregados as $index => $l)
                                    <tr class="sorteable_item" wire:key="lote-{{ $index }}">
                                        <td> {{ $l['razon_social'] }} </td>
                                        <td> {{ $l['descripcion'] }} </td>
                                        <td> {{ $l['id_manzana'] }} </td>
                                        <td> {{ $l['id_lote'] }} </td>
                                        <td>
                                            <button type="button" wire:click="quitarLote({{ $l['id_recaudo'] }})"
                                                class="boton_eliminar" @pointerdown.stop @mousedown.stop
                                                @touchstart.stop draggable="false">

                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

            </div>

            <!-- DERECHA -->
            <div class="g_columna_4 g_gap_pagina g_columna_invertir">
                <div class="g_panel">
                    @if (session('info'))
                        <div class="g_alerta_info">
                            <i class="fa-solid fa-circle-check"></i>
                            {{ session('info') }}
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="g_alerta_succes">
                            <i class="fa-solid fa-circle-check"></i>
                            {{ session('success') }}
                        </div>
                    @endif
                    <h4 class="g_panel_titulo">Cliente</h4>

                    <div class="g_margin_bottom_10">
                        <label for="dni">DNI/CE/RUC <span class="obligatorio"><i
                                    class="fa-solid fa-asterisk"></i></span></label>
                        <input type="text" id="dni" wire:model.live="dni"
                            x-on:input="$el.value = $el.value.replace(/[^0-9]/g, '')" required>
                    </div>

                    <div class="formulario_botones g_margin_bottom_10">
                        <button wire:click="buscarCliente" class="guardar" wire:loading.attr="disabled"
                            wire:target="buscarCliente">
                            <span wire:loading.remove wire:target="buscarCliente">Buscar</span>
                            <span wire:loading wire:target="buscarCliente">Buscando...</span>
                        </button>
                    </div>

                    @if ($mostrar_form_email)
                        <div class="g_margin_bottom_10">
                            <label for="email">Email <span class="obligatorio">*</span></label>
                            <input type="email" id="email" wire:model="email" required>
                            @error('email')
                                <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="formulario_botones">
                            <button wire:click="registrarClienteNuevo" class="guardar" wire:loading.attr="disabled"
                                wire:target="registrarClienteNuevo">
                                <span wire:loading.remove wire:target="registrarClienteNuevo">Registrar</span>
                                <span wire:loading wire:target="registrarClienteNuevo">Registrando...</span>
                            </button>
                        </div>
                    @endif
                </div>

                @if ($cliente_encontrado)
                    <div class="g_panel">
                        <h4 class="g_panel_titulo">Razón social</h4>
                        <select wire:model.live="razon_social_id" id="razon_social_id" name="razon_social_id">
                            <option value="">Todos</option>
                            @foreach ($razones_sociales as $empresa)
                                <option value="{{ $empresa['id_empresa'] }}">
                                    {{ $empresa['razon_social'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    @if (is_array($lotes) && !empty($lotes))
                        <div class="g_panel">
                            <h4 class="g_panel_titulo">Lotes</h4>

                            <div class="g_margin_bottom_10">
                                <select wire:model.live="lote_id">
                                    <option value="">Seleccionar lote</option>
                                    @foreach ($lotes as $lote)
                                        <option value="{{ $lote['id_recaudo'] }}">
                                            {{ $lote['descripcion'] }} - {{ $lote['id_manzana'] }} -
                                            {{ $lote['id_lote'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="formulario_botones">
                                <button wire:click="agregarLote" class="guardar" wire:loading.attr="disabled"
                                    wire:target="agregarLote">
                                    <span wire:loading.remove wire:target="agregarLote">Agregar</span>
                                    <span wire:loading wire:target="agregarLote">Agregando...</span>
                                </button>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>

        <div class="g_margin_top_20">
            <div class="formulario_botones">
                <button wire:click="store" class="guardar" wire:loading.attr="disabled" wire:target="store">
                    <span wire:loading.remove wire:target="store">Crear</span>
                    <span wire:loading wire:target="store">Guardando...</span>
                </button>

                <a href="{{ route('admin.ticket.vista.todo') }}" class="cancelar">Cancelar</a>
            </div>
        </div>
    </div>
</div>
