@section('tituloPagina', 'Envío CAVALI #{{ $envio->id }}')

@section('anchoPantalla', '100%')

<div class="g_gap_pagina">
    <div class="g_panel cabecera_titulo_pagina">
        <h2>Envío CAVALI #{{ $envio->id }}</h2>

        <div class="cabecera_titulo_botones">
            <a href="{{ route('admin.solicitar-letra-digital.vista.todo') }}" class="g_boton g_boton_light">
                Inicio <i class="fa-solid fa-house"></i></a>

            <a href="{{ route('admin.envios-cavali.vista.todo') }}" class="g_boton g_boton_dark">
                <i class="fa-solid fa-arrow-left"></i> Regresar
            </a>
        </div>
    </div>

    <div class="g_panel">

        <h3>Información del Envío</h3>

        <div class="formulario">
            <div class="g_fila">
                <div class="g_columna_3">
                    <label>Unidad de Negocio</label>
                    <p class="g_negrita">{{ $envio->unidadNegocio->razon_social }}</p>
                </div>

                <div class="g_columna_3">
                    <label>Fecha de Corte</label>
                    <p class="g_negrita">{{ $envio->fecha_corte->format('d/m/Y') }}</p>
                </div>

                <div class="g_columna_3">
                    <label>Estado</label>
                    <p>
                        @php
                            $badgeClass = match ($envio->estado) {
                                'pendiente' => 'g_badge_warning',
                                'enviado' => 'g_badge_info',
                                'observado' => 'g_badge_danger',
                                'aceptado' => 'g_badge_success',
                                default => 'g_badge_secondary'
                            };
                        @endphp
                        <span class="g_badge {{ $badgeClass }}">{{ ucfirst($envio->estado) }}</span>
                    </p>
                </div>
            </div>

            <div class="g_fila">
                <div class="g_columna_3">
                    <label>Total de Solicitudes</label>
                    <p class="g_negrita">{{ $envio->solicitudes->count() }}</p>
                </div>

                <div class="g_columna_3">
                    <label>Fecha de Envío</label>
                    <p>{{ $envio->enviado_at?->format('d/m/Y H:i') ?? 'No enviado' }}</p>
                </div>

                <div class="g_columna_3">
                    <label>Archivo</label>
                    @if($envio->archivo_zip)
                        <button wire:click="descargarArchivo" class="g_boton g_boton_success g_boton_sm">
                            <i class="fa-solid fa-download"></i> {{ $envio->archivo_nombre }}
                        </button>
                    @else
                        <p>No disponible</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="tabla_cabecera">
            <div class="tabla_cabecera_botones">
                <button wire:click="descargarAceptantes" class="g_boton g_boton_primary">
                    <i class="fa-solid fa-download"></i> Descargar ACEPTANTE
                </button>

                <button wire:click="descargarLetras" class="g_boton g_boton_primary">
                    <i class="fa-solid fa-download"></i> Descargar LETRAS
                </button>

                <button wire:click="descargarGirador" class="g_boton g_boton_primary">
                    <i class="fa-solid fa-download"></i> Descargar GIRADOR
                </button>
            </div>
        </div>
    </div>

    <div class="g_panel">
        <div class="tabla_contenido g_margin_bottom_20">
            <div class="contenedor_tabla">
                <table class="tabla">
                    <thead>
                        <tr>
                            <th>Nº</th>
                            <th>LETRA</th>
                            <th>Código Venta</th>
                            <th>Proyecto</th>
                            <th>Etapa</th>
                            <th>Mz.</th>
                            <th>Lt.</th>
                            <th>N° Cuota</th>
                            <th>Cliente</th>
                            <th>DNI</th>
                            <th>Estado CAVALI</th>
                            <th>Fecha Solicitud</th>
                        </tr>
                    </thead>

                    @if ($envio->solicitudes->count())
                        <tbody>
                            @foreach ($envio->solicitudes as $index => $solicitud)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $solicitud->codigo_venta }}-{{ $solicitud->numero_cuota }}</td>
                                    <td class="g_negrita">{{ $solicitud->codigo_venta }}</td>
                                    <td class="g_resumir">{{ $solicitud->proyecto->nombre ?? '—' }}</td>
                                    <td>{{ $solicitud->etapa ?? '—' }}</td>
                                    <td>{{ $solicitud->manzana ?? '—' }}</td>
                                    <td>{{ $solicitud->lote ?? '—' }}</td>
                                    <td class="g_negrita">{{ $solicitud->numero_cuota }}</td>
                                    <td class="g_resumir">{{ $solicitud->userCliente->name ?? '—' }}</td>
                                    <td>{{ $solicitud->userCliente?->cliente?->dni ?? '—' }}</td>
                                    <td>
                                        @php
                                            $estadoBadge = match ($solicitud->estado_cavali) {
                                                'pendiente' => 'g_badge_warning',
                                                'enviado' => 'g_badge_info',
                                                'observado' => 'g_badge_danger',
                                                'aceptado' => 'g_badge_success',
                                                default => 'g_badge_secondary'
                                            };
                                        @endphp
                                        <span class="g_badge {{ $estadoBadge }}">{{ ucfirst($solicitud->estado_cavali) }}</span>
                                    </td>
                                    <td>{{ $solicitud->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    @endif
                </table>
            </div>
        </div>

        @if ($envio->solicitudes->count() == 0)
            <div class="g_vacio">
                <p>No hay solicitudes en este envío.</p>
                <i class="fa-regular fa-face-grin-wink"></i>
            </div>
        @endif
    </div>
</div>