<div>
    <div class="g_panel">
        @if ($archivos->count())
        <div class="grid_instagram g_margin_bottom_20">
            @foreach ($archivos as $archivo)
            @php
            $extension = strtolower(pathinfo($archivo->path, PATHINFO_EXTENSION));

            $iconos = [
            'pdf' => 'fa-file-pdf text-red-600',
            'docx' => 'fa-file-word text-blue-600',
            'xlsx' => 'fa-file-excel text-green-600',
            'pptx' => 'fa-file-powerpoint text-orange-500',
            ];
            @endphp
            <div class="item">
                <div class="contenedor_imagen">
                    <div class="icono_archivo">
                        <i class="fa-solid {{ $iconos[$extension] ?? 'fa-file text-gray-500' }}"></i>
                        <small>{{ strtoupper($extension) }}</small>
                    </div>
                </div>

                <div class="botones">
                    <a href="{{ $archivo->url }}" target="_blank" class="g_boton g_boton_info">
                        <i class="fa-solid fa-eye"></i>
                    </a>

                    <button type="button" class="g_boton g_boton_danger"
                        onclick="navigator.clipboard.writeText('{{ $archivo->url }}')">
                        <i class="fa-solid fa-copy"></i>
                    </button>

                    <button wire:click="seleccionarArchivo({{ $archivo->id }})" class="g_boton g_boton_primary">
                        <i class="fa-solid fa-pencil"></i>
                    </button>

                    <button type="button" class="g_boton g_boton_danger"
                        wire:click="$dispatch('eliminarArchivoAlertaLivewire', { archivoId: {{ $archivo->id }} })">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </div>
            </div>
            @endforeach
        </div>

        @if ($archivos->hasPages())
        <div class="g_paginacion">
            {{ $archivos->links('vendor.pagination.default-livewire') }}
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
        Livewire.on('eliminarArchivoAlertaLivewire', (archivoId) => {
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
                        Livewire.dispatch('listaEliminarArchivo', archivoId);
                    }
                })
            })
    </script>
    @endscript
</div>
