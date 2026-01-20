@section('tituloPagina', 'Editar evidencia pago')
@section('anchoPantalla', '100%')

<div class="g_gap_pagina">

    <div class="g_panel cabecera_titulo_pagina">
        <h2>Editar evidencia pago web</h2>

        <div class="cabecera_titulo_botones">
            <a href="{{ route('admin.evidencia-pago.vista.todo') }}" class="g_boton g_boton_light">
                Inicio <i class="fa-solid fa-house"></i>
            </a>

            <a href="{{ route('admin.evidencia-pago.vista.todo') }}" class="g_boton g_boton_darkt">
                <i class="fa-solid fa-arrow-left"></i> Regresar
            </a>
        </div>
    </div>

    <div class="formulario g_gap_pagina">
        <div class="g_fila">
            <div class="g_columna_8 g_gap_pagina">
                <div class="g_panel">
                    <h4 class="g_panel_titulo">Relacionar al proyecto y asignar gestor</h4>

                    <div class="g_fila">
                        <div class="g_margin_bottom_10 g_columna_3">
                            <label for="unidad_negocio_id">Razón Social <span class="obligatorio"><i
                                        class="fa-solid fa-asterisk"></i></span></label>
                            <select wire:model.live="unidad_negocio_id" id="unidad_negocio_id" name="unidad_negocio_id">
                                <option value="" disabled>Selecciona</option>
                                @foreach ($empresas as $empresa)
                                    <option value="{{ $empresa->id }}">{{ $empresa->nombre }}</option>
                                @endforeach
                            </select>
                            @error('unidad_negocio_id')
                                <span class="mensaje_error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="g_margin_bottom_10 g_columna_3">
                            <label for="proyecto_id">Proyecto <span class="obligatorio"><i
                                        class="fa-solid fa-asterisk"></i></span></label>
                            <select wire:model.live="proyecto_id" id="proyecto_id" name="proyecto_id">
                                <option value="" disabled>Selecciona</option>
                                @foreach ($proyectos as $proyecto)
                                    <option value="{{ $proyecto->id }}">{{ $proyecto->nombre }}</option>
                                @endforeach
                            </select>
                            @error('proyecto_id')
                                <span class="mensaje_error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="g_margin_bottom_10 g_columna_3">
                            <label for="gestor_id">
                                Gestor <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span>
                            </label>
                            <select id="gestor_id" wire:model.live="gestor_id" required>
                                <option value="" selected disabled>Seleccionar un asignado</option>
                                @foreach ($gestores as $usuario)
                                    <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                                @endforeach
                            </select>
                            @error('gestor_id')
                                <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="g_margin_bottom_10 g_columna_3">
                            <label for="estado_id">Estado<span class="obligatorio"><i
                                        class="fa-solid fa-asterisk"></i></span></label>
                            <select id="estado_id" wire:model.live="estado_id" required>
                                <option value="" selected disabled>Seleccionar un estado</option>
                                @foreach ($estados as $estado)
                                    <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                                @endforeach
                            </select>
                            @error('estado_id')
                                <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="formulario_botones">
                        <button wire:click="store" class="guardar" wire:loading.attr="disabled" wire:target="store">
                            <span wire:loading.remove wire:target="store">Actualizar</span>
                            <span wire:loading wire:target="store">Actualizando...</span>
                        </button>

                        <a href="{{ route('admin.evidencia-pago.vista.todo') }}" class="cancelar">Cancelar</a>
                    </div>
                </div>

                <div class="g_panel">
                    <h4 class="g_panel_titulo">Datos cliente</h4>

                    <div class="g_fila">
                        <div class="g_margin_bottom_10 g_columna_4">
                            <label>Cliente</label>
                            <input type="text" disabled
                                value="{{ $solicitud->userCliente->name ?? 'Sin asignar' }}">
                        </div>

                        <div class="g_margin_bottom_10 g_columna_4">
                            <label>DNI</label>
                            <input type="text" disabled
                                value="{{ $solicitud->userCliente->cliente->dni ?? 'Sin asignar' }}">
                        </div>

                        <div class="g_margin_bottom_10 g_columna_4">
                            <label>Email</label>
                            <input type="text" disabled
                                value="{{ $solicitud->userCliente->email ?? 'Sin asignar' }}">
                        </div>
                    </div>
                </div>

                <div class="g_panel">
                    <h4 class="g_panel_titulo">Transacción Bancaria (ERP)</h4>

                    <div class="g_fila">
                        <div class="g_margin_bottom_10 g_columna_3">
                            <label>Razón social</label>
                            <input type="text" disabled value="{{ $solicitud->razon_social ?? 'Sin asignar' }}">
                        </div>

                        <div class="g_margin_bottom_10 g_columna_3">
                            <label>Proyecto</label>
                            <input type="text" disabled value="{{ $solicitud->nombre_proyecto ?? 'Sin asignar' }}">
                        </div>

                        <div class="g_margin_bottom_10 g_columna_3">
                            <label>Etapa</label>
                            <input type="text" disabled value="{{ $solicitud->etapa ?? 'Sin asignar' }}">
                        </div>

                        <div class="g_margin_bottom_10 g_columna_3">
                            <label>Manzana</label>
                            <input type="text" disabled value="{{ $solicitud->manzana ?? 'Sin asignar' }}">
                        </div>
                    </div>

                    <div class="g_fila">
                        <div class="g_margin_bottom_10 g_columna_3">
                            <label>Codigo cliente</label>
                            <input type="text" disabled value="{{ $solicitud->codigo_cliente ?? 'Sin asignar' }}">
                        </div>

                        <div class="g_margin_bottom_10 g_columna_3">
                            <label>Lote</label>
                            <input type="text" disabled value="{{ $solicitud->lote ?? 'Sin asignar' }}">
                        </div>

                        <div class="g_margin_bottom_10 g_columna_3">
                            <label>Codigo cuota</label>
                            <input type="text" disabled value="{{ $solicitud->codigo_cuota ?? 'Sin asignar' }}">
                        </div>

                        <div class="g_margin_bottom_10 g_columna_3">
                            <label>N° cuota</label>
                            <input type="text" disabled value="{{ $solicitud->numero_cuota ?? 'Sin asignar' }}">
                        </div>
                    </div>

                    <div class="g_fila">
                        <div class="g_margin_bottom_10 g_columna_3">
                            <label>Penalidad</label>
                            <input type="text" disabled value="{{ $solicitud->slin_penalidad ?? 'Sin asignar' }}">
                        </div>
                        <div class="g_margin_bottom_10 g_columna_3">
                            <label>Cromprobante</label>
                            <input type="text" disabled value="{{ $solicitud->comprobante ?? 'Sin asignar' }}">
                        </div>
                        <div class="g_margin_bottom_10 g_columna_3">
                            <label>N° Operación</label>
                            <input type="text" disabled
                                value="{{ $solicitud->slin_numero_operacion ?? 'Sin asignar' }}">
                        </div>
                        <div class="g_margin_bottom_10 g_columna_3">
                            <label>Cuota Monto</label>
                            <input type="text" disabled value="{{ $solicitud->slin_monto ?? 'Sin asignar' }}">
                        </div>
                    </div>
                </div>

                <div class="g_panel g_gap_pagina">
                    @foreach ($solicitud->evidencias as $evidencia)
                        <div class="g_panel ">
                            <h4 class="g_panel_titulo">Medio de pago recibido ({{ $loop->iteration }})
                                @if ($evidencia->estado)
                                    <span class="g_badge" style="background: {{ $evidencia->estado->color }}">
                                        <i class="{{ $evidencia->estado->icono }}"></i>
                                        {{ $evidencia->estado->nombre }}
                                    </span>
                                @endif
                            </h4>

                            <div class="g_fila">
                                <div class="g_margin_bottom_10 g_columna_3">
                                    <label>Banco</label>
                                    <input type="text" disabled value="{{ $evidencia->banco ?? 'Sin asignar' }}">
                                </div>

                                <div class="g_margin_bottom_10 g_columna_3">
                                    <label>Fecha operación</label>
                                    <input type="text" disabled value="{{ $evidencia->fecha ?? 'Sin asignar' }}">
                                </div>

                                <div class="g_margin_bottom_10 g_columna_3">
                                    <label>N° Operación</label>
                                    <input type="text" disabled
                                        value="{{ $evidencia->numero_operacion ?? 'Sin asignar' }}">
                                </div>

                                <div class="g_margin_bottom_10 g_columna_3">
                                    <label>Monto</label>
                                    <input type="text" disabled value="{{ $evidencia->monto ?? 'Sin asignar' }}">
                                </div>
                            </div>

                            <div class="formulario_botones">
                                <button wire:click="seleccionarEvidencia({{ $evidencia->id }})"
                                    class="guardar {{ $evidencia->id === $evidenciaSeleccionadaId ? 'activo' : '' }}">
                                    Seleccionar evidencia
                                </button>


                                <a href="{{ $evidencia->url }}" target="_blank" class="guardar">
                                    Ver <i class="fa-regular fa-file-image fa-xl"></i>
                                </a>

                                <a href="{{ $evidencia->url }}" download class="cancelar">
                                    Descargar <i class="fa-solid fa-download"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

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

                    <h4 class="g_panel_titulo">Evidencia seleccionada</h4>

                    @if ($evidenciaSeleccionada)
                        <div class="g_centrar_elemento g_margin_bottom_20">
                            <a href="{{ $evidenciaSeleccionada->url }}" target="_blank">
                                <img src="{{ $evidenciaSeleccionada->url }}" alt="Comprobante"
                                    style="height: 520px;">
                            </a>
                        </div>

                        <div class="g_celda_wrap g_margin_bottom_10">
                            <span class="g_badge {{ $solicitud->slin_asbanc ? 'activo' : '' }}">
                                Asbanc: {{ $solicitud->slin_asbanc ? 'SI' : 'No' }}
                            </span>

                            <span class="g_badge {{ $solicitud->slin_evidencia ? 'activo' : '' }}">
                                Evidencia: {{ $solicitud->slin_evidencia ? 'SI' : 'No' }}
                            </span>
                        </div>

                        <div class="g_panel_parrafo">
                            <p>Lote:{{ $solicitud->lote_completo ?? 'Sin asignar' }}</p>
                            <p>Cliente cod.:{{ $solicitud->codigo_cliente ?? 'Sin asignar' }}</p>
                            <p>ID Cobranza/Transacción:{{ $solicitud->transaccion_id ?? 'Sin asignar' }}</p>
                        </div>

                        @if ($solicitud->slin_asbanc)
                            @if ($solicitud->fecha_validacion && $solicitud->slin_evidencia)
                                <div class="g_margin_bottom_10">
                                    <label>Fecha validación</label>
                                    <input type="text" disabled
                                        value="{{ $solicitud->fecha_validacion ? $solicitud->fecha_validacion->format('d/m/Y H:i') : 'Falta validar' }}">
                                </div>

                                <div class="g_margin_bottom_10">
                                    <label>Respuesta Slin</label>
                                    <input type="text" disabled
                                        value="{{ $solicitud->slin_respuesta ? $solicitud->slin_respuesta : 'Falta enviar a Slin' }}">
                                </div>
                            @else
                                <div class="g_margin_bottom_10">
                                    <div class="formulario_botones">
                                        <button wire:click="enviarSlin" class="guardar" wire:loading.attr="disabled"
                                            wire:target="enviarSlin">
                                            <span wire:loading.remove wire:target="enviarSlin">Enviar</span>
                                            <span wire:loading wire:target="enviarSlin">Enviando...</span>
                                        </button>
                                    </div>
                                </div>
                            @endif
                        @else
                            @if ($solicitud->fecha_validacion)
                                <div class="g_margin_bottom_10">
                                    <label>Fecha validación</label>
                                    <input type="text" disabled
                                        value="{{ $solicitud->fecha_validacion ? $solicitud->fecha_validacion->format('d/m/Y H:i') : 'Falta validar' }}">
                                </div>
                            @else
                                <div class="g_margin_bottom_10">
                                    <div class="formulario_botones">
                                        <button wire:click="cerrarManual" class="guardar"
                                            wire:loading.attr="disabled" wire:target="cerrarManual">
                                            <span wire:loading.remove wire:target="cerrarManual">Cerrar de manera
                                                manual</span>
                                            <span wire:loading wire:target="cerrarManual">Enviando...</span>
                                        </button>
                                    </div>
                                </div>
                            @endif
                        @endif
                    @else
                        <span>Seleccione una evidencia</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="g_fila">
            <div class="g_columna_8 g_gap_pagina">
                <div class="g_panel">
                    <h4 class="g_panel_titulo">Enviar observación por correo</h4>

                    <div class="g_margin_bottom_10">
                        <label for="mensaje">Observación <span class="obligatorio"><i
                                    class="fa-solid fa-asterisk"></i></span></label>
                        <textarea id="mensaje" wire:model.live="mensaje" rows="5"></textarea>
                        @error('mensaje')
                            <p class="mensaje_error">{{ $message }}</p>
                        @enderror
                    </div>
                    @if (!$solicitud->fecha_validacion && !$solicitud->slin_evidencia)
                        <div class="g_margin_bottom_10">
                            <div class="formulario_botones">
                                <button wire:click="enviarCorreo" class="guardar" wire:loading.attr="disabled"
                                    wire:target="enviarCorreo">
                                    <span wire:loading.remove wire:target="enviarCorreo"><i
                                            class="fa-solid fa-paper-plane"></i> Enviar correo</span>
                                    <span wire:loading wire:target="enviarCorreo">Enviando...</span>
                                </button>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="g_panel g_gap_pagina">
                    <h4 class="g_panel_titulo">Correos enviados</h4>

                    @if ($solicitud->correos->isEmpty())
                        <p>No se han enviado correos.</p>
                    @else
                        @foreach ($solicitud->correos as $correo)
                            <div class="g_panel">
                                <div>
                                    <span>
                                        {{ $correo->enviado_at->format('d/m/Y H:i') }}
                                    </span>
                                </div>

                                <div>
                                    {!! nl2br(e($correo->mensaje)) !!}
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
