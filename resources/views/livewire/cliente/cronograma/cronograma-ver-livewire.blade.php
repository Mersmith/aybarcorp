<div>
    <div class="cronograma_contenedor">
        <div class="tabla_contenido">
            <div class="contenedor_tabla">
                <table class="tabla_info">

                    <tr>
                        <td class="label">Proyecto</td>
                        <td class="valor grande" colspan="3">
                            {{ $cabecera['proyecto'] ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <td class="label">Etapa</td>
                        <td class="valor">{{ $cabecera['etapa'] ?? '-' }}</td>

                        <td class="label">Manzana - Lote</td>
                        <td class="valor">
                            {{ $cabecera['manzana'] ?? '-' }}
                            -
                            {{ $cabecera['lote'] ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <td class="label">Nombre Cliente</td>
                        <td class="valor" colspan="3">
                            {{ $cabecera['nombre_cliente'] ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <td class="label">DNI</td>
                        <td class="valor">{{ $cabecera['dni'] ?? '-' }}</td>

                        <td class="label">Fecha Emisión</td>
                        <td class="valor">{{ $cabecera['fecha_emision'] ?? '-' }}</td>
                    </tr>

                    <tr>
                        <td class="label">Precio Venta</td>
                        <td class="valor">S/ {{ $cabecera['precio_venta'] ?? '-' }}</td>

                        <td class="label">Impor. Financiado</td>
                        <td class="valor">S/ {{ $cabecera['importe_financiado'] ?? '-' }}</td>
                    </tr>

                    <tr>
                        <td class="label">Inicial</td>
                        <td class="valor">S/ {{ $cabecera['inicial_pagado'] ?? '-' }}</td>

                        <td class="label">Impor. Amortizado</td>
                        <td class="valor">S/ {{ $cabecera['importe_amortizado'] ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- TABLA DETALLE DsEL CRONOGRAMA -->
        <div class="tabla_contenido">
            <div class="contenedor_tabla">
                <table class="tabla_detalle">
                    <thead>
                        <tr>
                            <th>Nro</th>
                            <th>Fecha Venc.</th>
                            <th>Cuota</th>
                            <th>Mto. Amortizado</th>
                            <th>Saldo</th>
                            {{--<th>Penalidad</th>
                            <th>Dias Atraso</th>--}}
                            <th>Total</th>
                            <th>Evidencia</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach (($detalle ?? []) as $item)
                        <tr>
                            <td>{{ $item['NroCuota'] ?? '-' }}</td>
                            <td>{{ $item['fecha_vencimiento'] ?? '-' }}</td>
                            <td>S/ {{ $item['Montocuota'] ?? 0}}</td>
                            <td>S/ {{ $item['monto_amortizado'] ?? 0 }}</td>
                            <td>S/ {{ $item['saldo'] ?? 0 }}</td>
                            {{--<td> S/ {{ $item['penalidad'] ?? 0 }}</td>
                            <td>{{ $item['dias_atraso'] ?? '-' }}</td>--}}
                            <td>S/ {{ $item['total'] ?? 0 }}</td>
                            <td>
                                @if (!$item['codigo'])
                                <span class="g_boton g_boton_empresa_primario"
                                    style="cursor: not-allowed; pointer-events: none;">
                                    <i class="fa-solid fa-circle-check"></i>
                                    Comprobado
                                </span>
                                @else
                                @if ($item['comprobantes_count'] == 2)
                                <span class="g_boton g_boton_darkt">
                                    <i class="fa-solid fa-image"></i>
                                    En validación({{ $item['comprobantes_count'] }})
                                </span>
                                @elseif($item['comprobantes_count'] == 1)
                                <button wire:click="seleccionarCuota({{ json_encode($item) }})"
                                    class="g_boton g_boton_darkt">
                                    <i class="fas fa-upload"></i> En validación
                                    ({{ $item['comprobantes_count'] }})
                                </button>
                                @else
                                <button wire:click="seleccionarCuota({{ json_encode($item) }})"
                                    class="g_boton g_boton_empresa_secundario">
                                    <i class="fas fa-upload"></i> Subir evidencia
                                </button>
                                @endif
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if ($cuota)
    <div class="g_modal">
        <div class="modal_contenedor">
            <div class="modal_cerrar">
                <button wire:click="cerrarModalEvidenciaPago"><i class="fa-solid fa-xmark"></i></button>
            </div>

            <div class="modal_titulo g_panel_titulo">
                <h2>Subir evidencia de pago</h2>
            </div>

            <div class="modal_cuerpo">
                @livewire('cliente.open-ai.procesar-imagen-livewire', ['cuota' => $cuota, 'lote' => $lote], key('cuota_'
                . $cuota['codigo']))
            </div>
        </div>
    </div>
    @endif
</div>