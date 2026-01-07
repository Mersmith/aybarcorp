@section('tituloPagina', 'Editar cliente')

<div class="g_gap_pagina">

    <!-- CABECERA -->
    <div class="g_panel cabecera_titulo_pagina">
        <h2>Editar cliente web</h2>

        <div class="cabecera_titulo_botones">
            <a href="{{ route('admin.cliente.vista.todo') }}" class="g_boton g_boton_light">
                Inicio <i class="fa-solid fa-house"></i></a>

            <a href="{{ route('admin.cliente.vista.crear') }}" class="g_boton g_boton_primary">
                Crear <i class="fa-solid fa-square-plus"></i></a>

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
                <h4 class="g_panel_titulo">Datos del usuario</h4>

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
                <h4 class="g_panel_titulo">Enviar recuperar contraseña</h4>
                <div class="g_margin_bottom_10">
                    <label>Email</label>
                    <input type="text" disabled value="{{ $email }}">
                </div>

                <div class="formulario_botones">
                    <button type="submit" class="guardar" wire:loading.attr="disabled" wire:target="enviarRecuperarClave">
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
