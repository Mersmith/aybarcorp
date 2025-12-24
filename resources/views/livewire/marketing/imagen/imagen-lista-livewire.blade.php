<div>
    <div class="g_panel">
        @if ($imagenes->count())
        <div class="grid_instagram g_margin_bottom_20">
            @foreach ($imagenes as $imagen)
            <div class="item">
                <div class="contenedor_imagen">
                    <img src="{{ $imagen->url }}" alt="{{ $imagen->titulo }}" class="imagen">
                </div>

                <div class="botones">
                    <a href="{{ $imagen->url }}" target="_blank" class="g_boton g_boton_info">
                        <i class="fa-solid fa-eye"></i>
                    </a>

                    <button type="button" class="g_boton g_boton_danger"
                        onclick="navigator.clipboard.writeText('{{ $imagen->url }}')">
                        <i class="fa-solid fa-copy"></i>
                    </button>

                    <button wire:click="seleccionarImagen({{ $imagen->id }})" class="g_boton g_boton_primary">
                        <i class="fa-solid fa-pencil"></i>
                    </button>

                    <button type="button" class="g_boton g_boton_danger"
                        wire:click="$dispatch('eliminarImagenAlertaLivewire', { imagenId: {{ $imagen->id }} })">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </div>
            </div>
            @endforeach
        </div>

        @if ($imagenes->hasPages())
        <div class="g_paginacion">
            {{ $imagenes->links('vendor.pagination.default-livewire') }}
        </div>
        @endif
        @else
        <div class="g_vacio">
            <p>No hay elementos.</p>
            <i class="fa-regular fa-face-grin-wink"></i>
        </div>
        @endif
    </div>

    @script
    <script>
        Livewire.on('eliminarImagenAlertaLivewire', (imagenId) => {
                Swal.fire({
                    title: '¿Quieres quitar?',
                    text: "No podrás recuperarlo.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '¡Sí, eliminar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('listaEliminarImagen', imagenId);
                    }
                })
            })
    </script>
    @endscript
</div>
