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

                        <td class="label">Código pago</td>
                        <td class="valor">{{ $lote['id_recaudo'] ?? '-' }}</td>
                    </tr>

                    <tr>
                        <td class="label">N° Cuotas</td>
                        <td class="valor">{{ $lote['nro_cuotas'] }}</td>

                        <td class="label">Cuotas pagadas</td>
                        <td class="valor">{{ $total_pagados }}</td>
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
                            <th>Estado</th>
                            <th>Evidencia</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach (($detalle ?? []) as $item)
                        <tr>
                            <td>{{ $item['NroCuota'] ?? '-' }}</td>
                            <td>{{ $item['fecha_vencimiento'] ?? '-' }}</td>
                            <td>
                                S/ {{ number_format((float)($item['Montocuota'] ?? 0), 2) }}
                            </td>
                            <td>
                                S/ {{ number_format((float)($item['monto_amortizado'] ?? 0), 2) }}
                            </td>
                            <td>
                                S/ {{ number_format((float)str_replace(',', '', $item['saldo'] ?? 0), 2) }}
                            </td>
                            <td></td>
                            <td>

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