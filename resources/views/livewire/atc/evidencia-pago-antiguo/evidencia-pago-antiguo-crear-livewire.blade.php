@section('tituloPagina', 'Crear evidencia pago antiguo')
@section('anchoPantalla', '100%')

<div class="g_gap_pagina">

    <div class="g_panel cabecera_titulo_pagina">
        <h2>Crear evidencia pago stock</h2>

        <div class="cabecera_titulo_botones">
            <a href="{{ route('admin.evidencia-pago-antiguo.vista.todo') }}" class="g_boton g_boton_light">
                Inicio <i class="fa-solid fa-house"></i>
            </a>

            <a href="{{ route('admin.evidencia-pago-antiguo.vista.todo') }}" class="g_boton g_boton_darkt">
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
                    </div>

                    <div class="g_fila">
                        <div class="g_margin_bottom_10 g_columna_4">
                            <label for="etapa">Etapa <span class="obligatorio"><i
                                        class="fa-solid fa-asterisk"></i></span></label>
                            <input type="text" id="etapa" wire:model.live="etapa">
                            @error('etapa')
                            <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="g_margin_bottom_10 g_columna_4">
                            <label for="lote">Lote <span class="obligatorio"><i
                                        class="fa-solid fa-asterisk"></i></span></label>
                            <input type="text" id="lote" wire:model.live="lote">
                            @error('lote')
                            <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="g_margin_bottom_10 g_columna_4">
                            <label for="numero_cuota">N° Cuota <span class="obligatorio"><i
                                        class="fa-solid fa-asterisk"></i></span></label>
                            <input type="text" id="numero_cuota" wire:model.live="numero_cuota">
                            @error('numero_cuota')
                            <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="g_fila">
                        <div class="g_margin_bottom_10 g_columna_4">
                            <label for="operacion_numero">N° Operación <span class="obligatorio"><i
                                        class="fa-solid fa-asterisk"></i></span></label>
                            <input type="text" id="operacion_numero" wire:model.live="operacion_numero">
                            @error('operacion_numero')
                            <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="g_margin_bottom_10 g_columna_4">
                            <label for="monto">Monto <span class="obligatorio"><i
                                        class="fa-solid fa-asterisk"></i></span></label>
                            <input type="number" step="0.01" id="monto" wire:model.live="monto">
                            @error('monto')
                            <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="g_margin_bottom_10 g_columna_4">
                            <label for="fecha_deposito">Fecha deposito <span class="obligatorio"><i
                                        class="fa-solid fa-asterisk"></i></span></label>
                            <input type="date" id="fecha_deposito" wire:model.live="fecha_deposito">
                            @error('fecha_deposito')
                            <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="g_fila">
                        <div class="g_margin_bottom_10 g_columna_4">
                            <label for="dni_cliente">DNI Cliente<span class="obligatorio"><i
                                        class="fa-solid fa-asterisk"></i></span></label>
                            <input type="text" id="dni_cliente" wire:model.live="dni_cliente">
                            @error('dni_cliente')
                            <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="g_margin_bottom_10 g_columna_4">
                            <label for="codigo_cliente">Código cliente <span class="obligatorio"><i
                                        class="fa-solid fa-asterisk"></i></span></label>
                            <input type="text" id="codigo_cliente" wire:model.live="codigo_cliente">
                            @error('codigo_cliente')
                            <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="g_margin_bottom_10 g_columna_4">
                            <label for="nombres_cliente">Nombres cliente <span class="obligatorio"><i
                                        class="fa-solid fa-asterisk"></i></span></label>
                            <input type="text" id="nombres_cliente" wire:model.live="nombres_cliente">
                            @error('nombres_cliente')
                            <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>


                    <div class="g_fila">
                        <div class="g_margin_bottom_10 g_columna_12">
                            <label for="imagen_url">URL imagen<span class="obligatorio"><i
                                        class="fa-solid fa-asterisk"></i></span></label>
                            <input type="text" id="imagen_url" wire:model.live="imagen_url">
                            @error('imagen_url')
                            <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- DERECHA -->
            <div class="g_columna_4 g_gap_pagina g_columna_invertir">
                <div class="g_panel">
                    <label for="estado_evidencia_pago_id">Estado<span class="obligatorio"><i
                                class="fa-solid fa-asterisk"></i></span></label>
                    <select id="estado_evidencia_pago_id" wire:model.live="estado_evidencia_pago_id" required>
                        <option value="" selected disabled>Seleccionar un estado</option>
                        @foreach ($estados as $estado)
                        <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                        @endforeach
                    </select>
                    @error('estado_evidencia_pago_id')
                    <p class="mensaje_error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="g_margin_top_20">
            <div class="formulario_botones">
                <button wire:click="store" class="guardar" wire:loading.attr="disabled" wire:target="store">
                    <span wire:loading.remove wire:target="store">Crear</span>
                    <span wire:loading wire:target="store">Guardando...</span>
                </button>

                <a href="{{ route('admin.evidencia-pago-antiguo.vista.todo') }}" class="cancelar">Cancelar</a>
            </div>
        </div>
    </div>
</div>