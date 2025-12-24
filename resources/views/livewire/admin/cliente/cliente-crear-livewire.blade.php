@section('tituloPagina', 'Crear cliente')

<div class="g_gap_pagina">
    <div class="g_panel cabecera_titulo_pagina">
        <h2>Crear cliente</h2>

        <div class="cabecera_titulo_botones">
            <a href="{{ route('admin.cliente.vista.todo') }}" class="g_boton g_boton_light">
                Inicio <i class="fa-solid fa-house"></i>
            </a>

            <a href="{{ route('admin.cliente.vista.todo') }}" class="g_boton g_boton_darkt">
                <i class="fa-solid fa-arrow-left"></i> Regresar
            </a>
        </div>
    </div>

    <div class="formulario">
        <div class="g_fila">
            <div class="g_gap_pagina">
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
                                <span wire:loading.remove wire:target="registrarClienteNuevo">Registrar cliente</span>
                                <span wire:loading wire:target="registrarClienteNuevo">Registrando...</span>
                            </button>
                        </div>
                    @endif
                </div>

                @if ($cliente_encontrado)
                    <div class="g_panel">
                        <h4 class="g_panel_titulo">Razón social</h4>

                        <div class="tabla_contenido">
                            <div class="contenedor_tabla">
                                <table class="tabla">
                                    <thead>
                                        <tr>
                                            <th>Nº</th>
                                            <th>Nombre</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($razones_sociales as $index => $empresa)
                                            <tr>
                                                <td> {{ $index + 1 }} </td>
                                                <td class="g_resaltar">{{ $empresa['razon_social'] }}</td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>

</div>
