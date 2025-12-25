<div class="g_gap_pagina">
    @if (session()->has('success'))
        <div class="g_alerta_succes">
            <i class="fa-solid fa-circle-check"></i>
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="g_alerta_error">
            <i class="fa-solid fa-triangle-exclamation"></i>
            {{ session('error') }}
        </div>
    @endif

    <div class="g_panel">
        <div class="g_panel_titulo">
            <h2>
                {{ $cliente->user && $cliente->user->name
                    ? 'Bienvenido, ' . collect(explode(' ', trim($cliente->user->name)))->last() . '!'
                    : 'Mi perfil' }}
            </h2>
        </div>

        <form wire:submit.prevent="actualizarDatos" class="formulario">
            <div class="g_fila">
                <div class="g_margin_top_20 g_columna_12">
                    <label>Nombres y apellidos</label>
                    <input type="text" disabled value="{{ $cliente->user->name ?? 'Sin asignar' }}">
                </div>
            </div>

            <div class="g_fila">
                <div class="g_margin_top_20 g_columna_4">
                    <label for="dni">DNI</label>
                    <input type="text" wire:model="dni" name="dni" id="dni" autocomplete="off" readonly
                        disabled>
                    @error('dni')
                        <span class="mensaje_error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="g_margin_top_20 g_columna_4">
                    <label for="email">Email</label>
                    <input type="email" wire:model="email" name="email" id="email" autocomplete="email" readonly
                        disabled>
                </div>

                <div class="g_margin_top_20 g_columna_4">
                    <label for="telefono_principal">Celular</label>
                    <input type="text" wire:model="telefono_principal" name="telefono_principal"
                        id="telefono_principal" autocomplete="tel">
                    @error('telefono_principal')
                        <span class="mensaje_error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="g_margin_top_20 formulario_botones">
                <button type="submit" class="guardar">Confirma tus datos</button>
            </div>
        </form>
    </div>

    <div class="g_panel">
        <div class="g_panel_titulo">
            <h2>Cambiar contraseña</h2>
        </div>

        <form wire:submit.prevent="actualizarClave" class="formulario">
            <div class="g_fila">
                <div class="g_margin_top_20 g_columna_6">
                    <label for="clave_actual">Contraseña actual <span class="obligatorio"><i
                                class="fa-solid fa-asterisk"></i></span></label>
                    <input type="password" wire:model="clave_actual" name="clave_actual" id="clave_actual">
                    @error('clave_actual')
                        <span class="mensaje_error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="g_margin_top_20 g_columna_6">
                    <label for="clave_nueva">Nueva contraseña <span class="obligatorio"><i
                                class="fa-solid fa-asterisk"></i></span></label>
                    <input type="password" wire:model="clave_nueva" name="clave_nueva" id="clave_nueva">
                    @error('clave_nueva')
                        <span class="mensaje_error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="g_margin_top_20 formulario_botones">
                <button type="submit" class="guardar">Cambiar contraseña</button>
            </div>
        </form>
    </div>
</div>
