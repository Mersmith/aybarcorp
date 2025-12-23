<div>
    <div class="g_panel">
        <div class="g_panel_titulo">
            <h2>Mis direcciones</h2>
        </div>

        <div class="g_lista">
            @if ($direcciones->isEmpty())
                <p>No tienes direcciones registradas.</p>
            @else
                @foreach ($direcciones as $direccion)
                    <div class="lista_item">
                        <div class="dos_bloques">
                            <div>
                                @if ($direccion->es_principal)
                                    <i class="fa-solid fa-heart"></i>
                                @else
                                    <i class="fa-regular fa-heart"
                                        wire:click="establecerPrincipal({{ $direccion->id }})"></i>
                                @endif
                            </div>

                            <div>
                                <p><span>Recibe: </span>{{ $direccion->recibe_nombres }}</p>
                                <p><span>Teléfono: </span>{{ $direccion->recibe_celular }}</p>
                                <p><span>Dirección: </span>{{ $direccion->direccion }}
                                    {{ $direccion->direccion_numero }}
                                </p>
                                <p><span>Dirección: </span>
                                    {{ $direccion->region->nombre }} / {{ $direccion->provincia->nombre }} /
                                    {{ $direccion->distrito->nombre }}</p>
                                <p><span>Código Postal:</span>{{ $direccion->codigo_postal }}</p>
                                @if ($direccion->es_principal)
                                    <p>Dirección principal</p>
                                @endif
                            </div>
                        </div>

                        <div class="botones">
                            <button wire:click="editarDireccion({{ $direccion->id }})">Editar</button>
                            <button wire:click="confirmDelete({{ $direccion->id }})">Eliminar</button>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        @if ($direcciones->isEmpty())
            <div class="g_margin_top_20 formulario">
                <div class="formulario_botones">
                    <button wire:click="$set('estadoModalCrear', true)" class="guardar">Nueva dirección</button>
                </div>
            </div>
        @endif
    </div>

    <!-- MODAL CREAR DIRECCION -->
    @if ($estadoModalCrear)
        @livewire('cliente.direccion.direccion-crear-livewire', ['origen' => ''])
    @endif

    <!-- MODAL EDITAR DIRECCION -->
    @if ($estadoModalEditar)
        @livewire('cliente.direccion.direccion-editar-livewire', ['direccionId' => $editar_direccion_id, 'origen' => ''])
    @endif

    <!-- MODAL CONFIRMAR ELIMINAR DIRECCION -->
    @if ($estadoModalEliminar)
        <div class="g_modal">
            <div class="modal_contenedor">
                <div class="modal_cerrar">
                    <button wire:click="$set('estadoModalEliminar', false)"><i class="fa-solid fa-xmark"></i></button>
                </div>

                <div class="modal_titulo r_titulo_panel">
                    <h2>Eliminar dirección</h2>
                </div>

                <div class="modal_cuerpo g_formulario">
                    <p>¿Realmente quieres eliminar la dirección?</p>
                    <br>
                    <div class="modal_pie">
                        <button wire:click="$set('estadoModalEliminar', false)">Cancelar</button>
                        <button wire:click="deleteDireccion">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
