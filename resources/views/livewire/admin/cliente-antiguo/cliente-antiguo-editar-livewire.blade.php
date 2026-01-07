@section('tituloPagina', 'Editar cliente antiguo')
@section('anchoPantalla', '100%')

<div class="g_gap_pagina">
    <div class="g_panel cabecera_titulo_pagina">
        <h2>Editar cliente antiguo</h2>

        <div class="cabecera_titulo_botones">
            <a href="{{ route('admin.cliente-bd-antiguo.vista.todo') }}" class="g_boton g_boton_light">
                Inicio <i class="fa-solid fa-house"></i>
            </a>

            <a href="{{ route('admin.cliente-bd-antiguo.vista.todo') }}" class="g_boton g_boton_darkt">
                <i class="fa-solid fa-arrow-left"></i> Regresar
            </a>
        </div>
    </div>

    <div class="formulario">
        <div class="g_fila">
            <div class="g_columna_8 g_gap_pagina">
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
                        <input type="text" id="dni" wire:model.live="dni" required>
                        @error('dni')
                            <p class="mensaje_error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                @if ($informaciones->isNotEmpty())
                    <div class="g_panel">
                        <h4 class="g_panel_titulo">Proyectos</h4>

                        <div class="tabla_contenido">
                            <div class="contenedor_tabla">
                                <table class="tabla">
                                    <thead>
                                        <tr>
                                            <th>Nº</th>
                                            <th>Razón Social</th>
                                            <th>Proyecto</th>
                                            <th>Etapa</th>
                                            <th>N° Lote</th>
                                            <th>Nombre</th>
                                            <th>Código</th>
                                            <th>DNI/RUC</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($informaciones as $index => $informacion)
                                            <tr>
                                                <td> {{ $index + 1 }} </td>
                                                <td class="g_resaltar">{{ $informacion->razon_social }}</td>
                                                <td class="g_resaltar">{{ $informacion->proyecto }}</td>
                                                <td class="g_resaltar">{{ $informacion->etapa }}</td>
                                                <td class="g_resaltar">{{ $informacion->numero_lote }}</td>
                                                <td class="g_resaltar">{{ $informacion->nombre }}</td>
                                                <td class="g_resaltar">{{ $informacion->codigo_cliente }}</td>
                                                <td class="g_resaltar">{{ $informacion->dni }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="g_columna_4 g_gap_pagina g_columna_invertir">
                <div class="g_panel">

                    <h4 class="g_panel_titulo">Cliente</h4>

                    <div class="g_margin_bottom_10">
                        <label for="razon_social">Razón Social <span class="obligatorio"><i
                                    class="fa-solid fa-asterisk"></i></span></label>
                        <input type="text" id="razon_social" wire:model.live="razon_social">
                        @error('razon_social')
                            <p class="mensaje_error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="g_margin_bottom_10">
                        <label for="proyecto">Proyecto <span class="obligatorio"><i
                                    class="fa-solid fa-asterisk"></i></span></label>
                        <input type="text" id="proyecto" wire:model.live="proyecto">
                        @error('proyecto')
                            <p class="mensaje_error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="g_margin_bottom_10">
                        <label for="etapa">Etapa <span class="obligatorio"><i
                                    class="fa-solid fa-asterisk"></i></span></label>
                        <input type="text" id="etapa" wire:model.live="etapa">
                        @error('etapa')
                            <p class="mensaje_error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="g_margin_bottom_10">
                        <label for="lote">Lote <span class="obligatorio"><i
                                    class="fa-solid fa-asterisk"></i></span></label>
                        <input type="text" id="lote" wire:model.live="lote">
                        @error('lote')
                            <p class="mensaje_error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="g_margin_bottom_10">
                        <label for="nombre">Nombre <span class="obligatorio"><i
                                    class="fa-solid fa-asterisk"></i></span></label>
                        <input type="text" id="nombre" wire:model.live="nombre">
                        @error('nombre')
                            <p class="mensaje_error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="g_margin_bottom_10">
                        <label for="codigo">Codigo <span class="obligatorio"><i
                                    class="fa-solid fa-asterisk"></i></span></label>
                        <input type="text" id="codigo" wire:model.live="codigo">
                        @error('codigo')
                            <p class="mensaje_error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="formulario_botones g_margin_bottom_10">
                        <button wire:click="store" class="guardar" wire:loading.attr="disabled" wire:target="store">
                            <span wire:loading.remove wire:target="store">Actualizar</span>
                            <span wire:loading wire:target="store">Actualizando...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
