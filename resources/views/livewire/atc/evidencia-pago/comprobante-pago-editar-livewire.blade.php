@section('tituloPagina', 'Editar comprobante pago')
@section('anchoPantalla', '100%')

<div class="g_gap_pagina">

    <div class="g_panel cabecera_titulo_pagina">
        <h2>Editar comprobante pago</h2>

        <div class="cabecera_titulo_botones">
            <a href="{{ route('admin.comprobante-pago.vista.todo') }}" class="g_boton g_boton_light">
                Inicio <i class="fa-solid fa-house"></i>
            </a>

            <a href="{{ route('admin.comprobante-pago.vista.todo') }}" class="g_boton g_boton_darkt">
                <i class="fa-solid fa-arrow-left"></i> Regresar
            </a>
        </div>
    </div>

    <div class="formulario g_gap_pagina">
        <div class="g_fila">
            <div class="g_columna_8 g_gap_pagina">
                <div class="g_panel">
                    <h4 class="g_panel_titulo">General</h4>

                    <div class="g_fila">
                        <div class="g_margin_bottom_10 g_columna_3">
                            <label>Cliente</label>
                            <input type="text" disabled
                                value="{{ $comprobante->cliente->user->name ?? 'Sin asignar' }}">
                        </div>

                        <div class="g_margin_bottom_10 g_columna_3">
                            <label>DNI</label>
                            <input type="text" disabled value="{{ $comprobante->cliente->dni ?? 'Sin asignar' }}">
                        </div>

                        <div class="g_margin_bottom_10 g_columna_3">
                            <label>Email</label>
                            <input type="text" disabled value="{{ $comprobante->cliente->email ?? 'Sin asignar' }}">
                        </div>

                        <div class="g_margin_bottom_10 g_columna_3">
                            <label>Fecha subida</label>
                            <input type="text" disabled value="{{ $comprobante->created_at ?? 'Sin asignar' }}">
                        </div>
                    </div>
                </div>

                <div class="g_panel">
                    <h4 class="g_panel_titulo">Datos que ingreso el cliente</h4>

                    <div class="g_fila">
                        <div class="g_margin_bottom_10 g_columna_3">
                            <label>Razón social</label>
                            <input type="text" disabled value="{{ $comprobante->razon_social ?? 'Sin asignar' }}">
                        </div>

                        <div class="g_margin_bottom_10 g_columna_3">
                            <label>Proyecto</label>
                            <input type="text" disabled value="{{ $comprobante->nombre_proyecto ?? 'Sin asignar' }}">
                        </div>

                        <div class="g_margin_bottom_10 g_columna_3">
                            <label>Etapa</label>
                            <input type="text" disabled value="{{ $comprobante->etapa ?? 'Sin asignar' }}">
                        </div>

                        <div class="g_margin_bottom_10 g_columna_3">
                            <label>Manzana</label>
                            <input type="text" disabled value="{{ $comprobante->manzana ?? 'Sin asignar' }}">
                        </div>
                    </div>

                    <div class="g_fila">
                        <div class="g_margin_bottom_10 g_columna_3">
                            <label>Codigo cliente</label>
                            <input type="text" disabled value="{{ $comprobante->codigo_cliente ?? 'Sin asignar' }}">
                        </div>

                        <div class="g_margin_bottom_10 g_columna_3">
                            <label>Lote</label>
                            <input type="text" disabled value="{{ $comprobante->lote ?? 'Sin asignar' }}">
                        </div>

                        <div class="g_margin_bottom_10 g_columna_3">
                            <label>Codigo cuota</label>
                            <input type="text" disabled value="{{ $comprobante->codigo_cuota ?? 'Sin asignar' }}">
                        </div>

                        <div class="g_margin_bottom_10 g_columna_3">
                            <label>N° cuota</label>
                            <input type="text" disabled value="{{ $comprobante->numero_cuota ?? 'Sin asignar' }}">
                        </div>
                    </div>

                    <div class="g_fila">
                        <div class="g_margin_bottom_10 g_columna_3">
                            <label>N° Operación</label>
                            <input type="text" disabled value="{{ $comprobante->numero_operacion ?? 'Sin asignar' }}">
                        </div>

                        <div class="g_margin_bottom_10 g_columna_3">
                            <label>Banco</label>
                            <input type="text" disabled value="{{ $comprobante->banco ?? 'Sin asignar' }}">
                        </div>

                        <div class="g_margin_bottom_10 g_columna_3">
                            <label>Monto</label>
                            <input type="text" disabled value="{{ $comprobante->monto ?? 'Sin asignar' }}">
                        </div>

                        <div class="g_margin_bottom_10 g_columna_3">
                            <label>Fecha operación</label>
                            <input type="text" disabled value="{{ $comprobante->fecha ?? 'Sin asignar' }}">
                        </div>
                    </div>
                </div>

                <div class="g_panel">
                    <h4 class="g_panel_titulo">Detalle</h4>

                    <div class="g_fila">
                        <div class="g_margin_bottom_20 g_columna_6">
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

                        <div class="g_margin_bottom_20 g_columna_6">
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
                    </div>
                </div>
            </div>

            <div class="g_columna_4 g_gap_pagina g_columna_invertir">
                <div class="g_panel">
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

                <div class="g_panel">
                    <h4 class="g_panel_titulo">Imagen</h4>

                    @if ($comprobante->url)
                    <div class="g_centrar_elemento">
                        <a href="{{ $comprobante->url }}" target="_blank">
                            <img src="{{ $comprobante->url }}" alt="Comprobante" width="150">
                        </a>

                        <div class="formulario_botones g_margin_top_20 ">
                            <a href="{{ $comprobante->url }}" target="_blank" class="guardar">
                                Ver <i class="fa-regular fa-file-image fa-xl"></i>
                            </a>

                            <a href="{{ $comprobante->url }}" download class="cancelar">
                                Descargar <i class="fa-solid fa-download"></i>
                            </a>
                        </div>
                    </div>
                    @else
                    <span>Sin imagen</span>
                    @endif

                </div>
            </div>
        </div>

        <div class="formulario_botones">
            <button wire:click="store" class="guardar" wire:loading.attr="disabled" wire:target="store">
                <span wire:loading.remove wire:target="store">Actualizar</span>
                <span wire:loading wire:target="store">Actualizando...</span>
            </button>

            <a href="{{ route('admin.comprobante-pago.vista.todo') }}" class="cancelar">Cancelar</a>
        </div>

        <div class="g_fila">
            <div class="g_columna_8 g_gap_pagina">
                <div class="g_panel">
                    <h4 class="g_panel_titulo">Enviar observación por correo</h4>

                    <div class="g_margin_bottom_10">
                        <label for="observacion">Observación <span class="obligatorio"><i
                                    class="fa-solid fa-asterisk"></i></span></label>
                        <textarea id="observacion" wire:model.live="observacion" rows="5"></textarea>
                        @error('observacion')
                        <p class="mensaje_error">{{ $message }}</p>
                        @enderror
                    </div>

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
                </div>
            </div>

            <div class="g_columna_4 g_gap_pagina g_columna_invertir">
                <div class="g_panel">
                    <h4 class="g_panel_titulo">Validar evidencia pago</h4>

                    <div class="g_margin_bottom_10">
                        <label>Fecha validación</label>
                        <input type="text" disabled
                            value="{{ $comprobante->fecha_validacion ? $comprobante->fecha_validacion->format('d/m/Y H:i') : 'Falta validar' }}">
                    </div>

                    @can('evidencia-pago-validar')
                    @if (!$comprobante->fecha_validacion)
                    <div class="g_margin_bottom_10">
                        <div class="formulario_botones">
                            <button wire:click="validar" class="guardar" wire:loading.attr="disabled"
                                wire:target="validar">
                                <span wire:loading.remove wire:target="validar">Validar evidencia</span>
                                <span wire:loading wire:target="validar">Validando...</span>
                            </button>
                        </div>
                    </div>
                    @endif
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>