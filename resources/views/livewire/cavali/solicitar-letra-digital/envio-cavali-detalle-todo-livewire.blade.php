<div class="g_panel">
    <h2>Envío CAVALI #{{ $envio->id }}</h2>

    <p>
        Fecha corte: {{ $envio->fecha_corte->format('d/m/Y') }} <br>
        Estado: <strong>{{ strtoupper($envio->estado) }}</strong> <br>
        Total solicitudes: {{ $envio->solicitudes->count() }}
    </p>

    <div class="g_fila g_gap_10">
        <button wire:click="descargarAceptantes" class="btn btn-primary">
            Descargar ACEPTANTE
        </button>

        <button wire:click="descargarLetras" class="btn btn-success">
            Descargar LETRAS
        </button>

        <button wire:click="descargarGirador" class="btn btn-warning">
            Descargar GIRADOR
        </button>
    </div>
</div>