@section('tituloPagina', 'Editar cliente')

<div class="g_gap_pagina">

    <!-- CABECERA -->
    <div class="g_panel cabecera_titulo_pagina">
        <h2>Editar cliente portal</h2>

        <div class="cabecera_titulo_botones">
            <a href="{{ route('admin.cliente.vista.todo') }}" class="g_boton g_boton_light">
                Inicio <i class="fa-solid fa-house"></i></a>

            <a href="{{ route('admin.cliente.vista.consultar', $dni) }}" class="g_boton g_boton_secondary">
                Consultar <i class="fa-solid fa-magnifying-glass"></i></a>

            <button type="button" class="g_boton g_boton_danger" onclick="alertaClienteUser()">
                Eliminar <i class="fa-solid fa-trash-can"></i>
            </button>

            <a href="{{ route('admin.cliente.vista.todo') }}" class="g_boton g_boton_darkt">
                <i class="fa-solid fa-arrow-left"></i> Regresar
            </a>
        </div>
    </div>

    <!-- FORMULARIO -->
    <div class="g_fila formulario">
        <form wire:submit.prevent="store" class="g_columna_8 g_gap_pagina">
            <div class="g_panel">
                <h4 class="g_panel_titulo">Activo</h4>

                <select id="activo" name="activo" wire:model.live="activo">
                    <option value="0">DESACTIVADO</option>
                    <option value="1">ACTIVO</option>
                </select>
            </div>

            <div class="g_panel">
                <h4 class="g_panel_titulo">Datos del cliente</h4>

                <div class="g_margin_bottom_10">
                    <label for="name">Nombre <span class="obligatorio"><i
                                class="fa-solid fa-asterisk"></i></span></label>
                    <input type="text" id="name" wire:model.live="name">
                    @error('name')
                        <p class="mensaje_error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="g_margin_bottom_10">
                    <label for="email">Correo electrónico <span class="obligatorio"><i
                                class="fa-solid fa-asterisk"></i></span></label>
                    <input type="email" id="email" wire:model.live="email">
                    @error('email')
                        <p class="mensaje_error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="g_margin_bottom_10">
                    <label for="dni">Dni <span class="obligatorio"><i
                                class="fa-solid fa-asterisk"></i></span></label>
                    <input type="text" id="dni" wire:model.live="dni">
                    @error('dni')
                        <p class="mensaje_error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="g_margin_bottom_10">
                    <label for="telefono_principal">Celular</label>
                    <input type="text" id="telefono_principal" wire:model.live="telefono_principal">
                    @error('telefono_principal')
                        <p class="mensaje_error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            @if ($direccion)
                <div class="g_panel">
                    <h4 class="g_panel_titulo">Dirección del usuario</h4>

                    <div class="g_fila">
                        <div class="g_margin_bottom_10 g_columna_4">
                            <label>Departamento</label>
                            <input type="text" disabled value="{{ $direccion?->region?->nombre }}">
                        </div>

                        <div class="g_margin_bottom_10 g_columna_4">
                            <label>Provincia</label>
                            <input type="text" disabled value="{{ $direccion?->provincia?->nombre }}">
                        </div>

                        <div class="g_margin_bottom_10 g_columna_4">
                            <label>Distrito</label>
                            <input type="text" disabled value="{{ $direccion?->distrito?->nombre }}">
                        </div>
                    </div>

                    <div class="g_fila">
                        <div class="g_margin_bottom_10">
                            <label>Avenida / Calle / Jirón </label>
                            <input type="text" disabled value="{{ $direccion?->direccion }}">
                        </div>

                        <div class="g_margin_bottom_10">
                            <label>Número</label>
                            <input type="text" disabled value="{{ $direccion?->direccion_numero }}">
                        </div>
                    </div>

                    <div class="g_fila">
                        <div class="g_margin_bottom_10">
                            <label>Dpto. / Interior / Piso / Lote</label>
                            <input type="text" disabled value="{{ $direccion?->opcional }}">
                        </div>

                        <div class="g_margin_bottom_10">
                            <label>Código postal</label>
                            <input type="text" disabled value="{{ $direccion?->codigo_postal }}">
                        </div>
                    </div>

                    <div class="g_margin_bottom_10">
                        <label>Referencia de la ubicación</label>
                        <textarea type="text" disabled >{{ $direccion?->instrucciones }}</textarea>
                    </div>
                </div>
            @endif

            <div class="formulario_botones">
                <button type="submit" class="guardar" wire:loading.attr="disabled" wire:target="store">
                    <span wire:loading.remove wire:target="store">Actualizar</span>
                    <span wire:loading wire:target="store">Actualizando...</span>
                </button>

                <a href="{{ route('admin.cliente.vista.todo') }}" class="cancelar">Cancelar</a>
            </div>
        </form>
        <!-- COLUMNA DERECHA -->
        <form wire:submit.prevent="enviarRecuperarClave" class="g_columna_4 g_gap_pagina">
            <div class="g_panel">
                <h4 class="g_panel_titulo">Enviar email recuperar contraseña</h4>
                <div class="g_margin_bottom_10">
                    <label>Email</label>
                    <input type="text" disabled value="{{ $email }}">
                </div>

                <div class="formulario_botones">
                    <button type="submit" class="guardar" wire:loading.attr="disabled"
                        wire:target="enviarRecuperarClave">
                        <span wire:loading.remove wire:target="enviarRecuperarClave">Recuperar clave</span>
                        <span wire:loading wire:target="enviarRecuperarClave">Enviando...</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        function alertaClienteUser() {
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
                    Livewire.dispatch('eliminarClienteOn');

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
