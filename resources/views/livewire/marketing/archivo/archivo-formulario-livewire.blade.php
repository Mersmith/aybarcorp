<form wire:submit.prevent="guardar" class="formulario">
    <div class="g_panel">
        <div class="g_margin_bottom_20">
            <input type="file" id="archivos_inicial" wire:model="archivos_inicial" multiple
                accept=".docx,.xlsx,.pptx,.pdf" style="display: none;">

            <div class="contenedor_dropzone">
                @if ($archivos_final && count($archivos_final))
                @foreach ($archivos_final as $index => $archivo)
                <div class="dropzone_item">
                    @php
                    // Detectar tipo de archivo
                    $extension = method_exists($archivo, 'getClientOriginalExtension')
                    ? strtolower($archivo->getClientOriginalExtension())
                    : null;

                    $iconos = [
                    'pdf' => 'fa-file-pdf text-red-600',
                    'docx' => 'fa-file-word text-blue-600',
                    'xlsx' => 'fa-file-excel text-green-600',
                    'pptx' => 'fa-file-powerpoint text-orange-500',
                    ];
                    @endphp

                    <div class="dropzone_icono">
                        <i class="fa-solid {{ $iconos[$extension] ?? 'fa-file text-gray-500' }}"></i>
                        <small>{{ strtoupper($extension) }}</small>
                    </div>

                    <button type="button" class="remove_button" wire:click="eliminarArchivoTemporal({{ $index }})">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                @endforeach
                @else
                <div class="g_vacio">
                    <p>No hay archivos.</p>
                    <i class="fa-regular fa-face-grin-wink"></i>
                </div>
                @endif
            </div>
        </div>


        @error('archivos_final')
        <p class="mensaje_error">{{ $message }}</p>
        @enderror

        @if ($archivos_final && count($archivos_final))
        <div class="formulario_botones">
            <button type="submit" class="guardar">Guardar</button>
        </div>
        @endif
    </div>
</form>
