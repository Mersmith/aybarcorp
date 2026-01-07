@section('tituloPagina', 'Editar usuario')

<div class="g_gap_pagina">

    <!-- CABECERA -->
    <div class="g_panel cabecera_titulo_pagina">
        <h2>Editar usuario</h2>

        <div class="cabecera_titulo_botones">
            <a href="{{ route('admin.usuario.vista.todo') }}" class="g_boton g_boton_light">
                Inicio <i class="fa-solid fa-house"></i></a>

            <a href="{{ route('admin.usuario.vista.crear') }}" class="g_boton g_boton_primary">
                Crear <i class="fa-solid fa-square-plus"></i></a>

            <button type="button" class="g_boton g_boton_danger" onclick="alertaEliminarUser()">
                Eliminar <i class="fa-solid fa-trash-can"></i>
            </button>

            <a href="{{ route('admin.usuario.vista.todo') }}" class="g_boton g_boton_darkt">
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
            </div>

            <div class="g_panel">
                <h4 class="g_panel_titulo">Roles</h4>

                @foreach ($roles as $rol)
                    <label>
                        <input type="checkbox" wire:model.live="selectedRoles" value="{{ $rol->name }}">
                        {{ $rol->name }}
                    </label>
                @endforeach
            </div>

            <div class="formulario_botones">
                <button type="submit" class="guardar" wire:loading.attr="disabled" wire:target="store">
                    <span wire:loading.remove wire:target="store">Actualizar</span>
                    <span wire:loading wire:target="store">Actualizando...</span>
                </button>

                <a href="{{ route('admin.usuario.vista.todo') }}" class="cancelar">Cancelar</a>
            </div>
        </form>
        <!-- COLUMNA DERECHA -->
        <form wire:submit.prevent="actualizarClave" class="g_columna_4 g_gap_pagina">
            <div class="g_panel">
                <h4 class="g_panel_titulo">Seguridad </h4>
                <label for="password">Nueva contraseña <span class="obligatorio"><i
                            class="fa-solid fa-asterisk"></i></span></label>
                <input type="password" id="password" wire:model.live="password">
                @error('password')
                    <p class="mensaje_error">{{ $message }}</p>
                @enderror
            </div>

            <div class="formulario_botones">
                <button type="submit" class="guardar" wire:loading.attr="disabled" wire:target="actualizarClave">
                    <span wire:loading.remove wire:target="actualizarClave">Cambiar contraseña</span>
                    <span wire:loading wire:target="actualizarClave">Cambiando...</span>
                </button>
            </div>
        </form>
    </div>

    <script>
        function alertaEliminarUser() {
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
                    Livewire.dispatch('eliminarUserOn');

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
