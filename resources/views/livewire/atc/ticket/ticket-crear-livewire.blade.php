@section('tituloPagina', 'Crear ticket')
@section('anchoPantalla', '100%')

<div class="g_gap_pagina">
    <!-- CABECERA -->
    <div class="g_panel cabecera_titulo_pagina">
        <h2>Crear ticket
            @if ($ticketPadreId)
            asociado al ticket
            <a href="{{ route('admin.ticket.vista.editar', $ticketPadreId) }}" target="_blank">#{{ $ticketPadreId }}</a>
            @endif
        </h2>

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
                            <label for="unidad_negocio_id">
                                Empresa <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span>
                            </label>
                            <select id="unidad_negocio_id" wire:model.live="unidad_negocio_id" required>
                                <option value="" selected disabled>Seleccionar una empresa</option>
                                @foreach ($empresas as $empresa)
                                <option value="{{ $empresa->id }}">{{ $empresa->nombre }}</option>
                                @endforeach
                            </select>
                            @error('unidad_negocio_id')
                            <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="g_margin_bottom_10 g_columna_4">
                            <label for="proyecto_id">
                                Proyecto <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span>
                            </label>
                            <select id="proyecto_id" wire:model.live="proyecto_id" required>
                                <option value="" selected disabled>Seleccionar un proyecto</option>
                                @foreach ($proyectos as $proyecto)
                                <option value="{{ $proyecto->id }}">{{ $proyecto->nombre }}</option>
                                @endforeach
                            </select>
                            @error('proyecto_id')
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
                            <label for="sub_tipo_solicitud_id">
                                Sub tipo solicitud <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span>
                            </label>
                            <select id="sub_tipo_solicitud_id" wire:model.live="sub_tipo_solicitud_id" required>
                                <option value="" selected disabled>Seleccionar un subtipo</option>
                                @foreach ($sub_tipos_solicitudes as $subtipo)
                                <option value="{{ $subtipo->id }}">{{ $subtipo->nombre }}</option>
                                @endforeach
                            </select>
                            @error('sub_tipo_solicitud_id')
                            <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>

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
                    </div>

                    <div class="g_fila">
                        <div class="g_margin_bottom_10 g_columna_4">
                            <label for="cliente_id">
                                Cliente <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span>
                            </label>

                            @if ($ticketPadre)
                            <input type="text" disabled value="{{ $ticketPadre->nombres ?? 'Sin asignar' }}">
                            @else
                            <input type="text" disabled value="{{ $cliente?->nombre ?? 'Sin asignar' }}">
                            @error('cliente_id')
                            <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                            @endif
                        </div>

                        <div class="g_margin_bottom_10 g_columna_4">
                            <label>Estado</label>
                            <input type="text" value="Abierto" disabled>
                        </div>

                        <div class="g_margin_bottom_10 g_columna_4">
                            <label for="gestor_id">
                                Gestor <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span>
                            </label>
                            <select id="gestor_id" wire:model.live="gestor_id" required>
                                <option value="" disabled>Seleccionar un asignado</option>
                                @foreach ($gestores as $usuario)
                                <option value="{{ $usuario->id }}">
                                    {{ $usuario->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('gestor_id')
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
                            <textarea id="descripcion_inicial" wire:model.live="descripcion_inicial"
                                rows="5"></textarea>
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
                                <th>Mz./Lt.</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lotes_agregados as $index => $l)
                            <tr class="sorteable_item" wire:key="lote-{{ $index }}">
                                <td> {{ $l['razon_social'] }} </td>
                                <td> {{ $l['proyecto'] }} </td>
                                <td> {{ $l['numero_lote'] }} </td>
                                <td>
                                    <button type="button" wire:click="quitarLote('{{ $l['id'] }}')"
                                        class="boton_eliminar" @pointerdown.stop @mousedown.stop @touchstart.stop
                                        draggable="false">

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
                @if ($ticketPadre)
                <div class="g_panel">
                    <h4 class="g_panel_titulo">Ticket padre</h4>

                    <div class="g_fila">
                        <div class="g_margin_bottom_10 g_columna_6">
                            <label>Empresa</label>
                            <input type="text" disabled
                                value="{{ $ticketPadre->unidadNegocio->nombre ?? 'Sin asignar' }}">
                        </div>

                        <div class="g_margin_bottom_10 g_columna_6">
                            <label>Proyecto</label>
                            <input type="text" disabled value="{{ $ticketPadre->proyecto->nombre ?? 'Sin asignar' }}">
                        </div>
                    </div>

                    <div class="g_fila">
                        <div class="g_margin_bottom_10 g_columna_6">
                            <label>Área origen</label>
                            <input type="text" disabled value="{{ $ticketPadre->area->nombre ?? 'Sin asignar' }}">
                        </div>

                        <div class="g_margin_bottom_10 g_columna_6">
                            <label>Tipo solicitud</label>
                            <input type="text" disabled
                                value="{{ $ticketPadre->tipoSolicitud->nombre ?? 'Sin asignar' }}">
                        </div>
                    </div>

                    <div class="g_fila">
                        <div class="g_margin_bottom_10 g_columna_6">
                            <label>Sub tipo solicitud</label>
                            <input type="text" disabled
                                value="{{ $ticketPadre->subTipoSolicitud->nombre ?? 'Sin asignar' }}">
                        </div>

                        <div class="g_margin_bottom_10 g_columna_6">
                            <label>Canal</label>
                            <input type="text" disabled value="{{ $ticketPadre->canal->nombre ?? 'Sin asignar' }}">
                        </div>
                    </div>
                    <div class="g_fila">
                        <div class="g_margin_bottom_10 g_columna_6">
                            <label>Cliente</label>
                            <input type="text" disabled value="{{ $ticketPadre->nombres ?? 'Sin asignar' }}">
                        </div>

                        <div class="g_margin_bottom_10 g_columna_6">
                            <label for="gestor_id">
                                Asignado <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span>
                            </label>
                            <input type="text" disabled value="{{ $ticketPadre->gestor->name ?? 'Sin asignar' }}">
                        </div>
                    </div>
                    <div class="g_fila">
                        <div class="g_columna_12">
                            <label>Asunto </label>
                            <textarea disabled>{{ $ticketPadre->asunto_inicial ?? 'Sin asunto' }}</textarea>
                        </div>
                    </div>

                    <div class="g_fila">
                        <div class="g_columna_12">
                            <label>Descripción </label>
                            <textarea disabled>{{ $ticketPadre->descripcion_inicial ?? 'Sin descripción' }}</textarea>
                        </div>
                    </div>

                    @if (!empty($ticketPadre->lotes))
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
                                    @foreach ($ticketPadre->lotes as $index => $l)
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
                @else
                <div class="g_panel">
                    @if (session('info'))
                    <div class="g_alerta_info">
                        <i class="fa-solid fa-circle-check"></i>
                        {{ session('info') }}
                    </div>
                    @endif

                    @if (session('error'))
                    <div class="g_alerta_error">
                        <i class="fa-solid fa-circle-check"></i>
                        {{ session('error') }}
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
                        @error('dni')
                        <p class="mensaje_error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="formulario_botones g_margin_bottom_10">
                        <button wire:click="buscarCliente" class="guardar" wire:loading.attr="disabled"
                            wire:target="buscarCliente">
                            <span wire:loading.remove wire:target="buscarCliente">Buscar</span>
                            <span wire:loading wire:target="buscarCliente">Buscando...</span>
                        </button>
                    </div>
                </div>

                @if ($informaciones->isNotEmpty())
                <div class="g_panel">
                    <h4 class="g_panel_titulo">Lotes</h4>

                    <div class="g_margin_bottom_10">
                        <select wire:model.live="lote_id">
                            <option value="">Seleccionar lote</option>

                            @foreach ($informaciones as $lote)
                            <option value="{{ $lote->id }}">
                                {{ $lote->razon_social }} - {{ $lote->proyecto }} -
                                {{ $lote->numero_lote }}
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