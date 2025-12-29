<div>
    <div class="cronograma_contenedor">
        <div class="tabla_contenido">
            <div class="contenedor_tabla">
                <table class="tabla_info">

                    <tr>
                        <td class="label">Proyecto</td>
                        <td class="valor grande" colspan="3">
                            {{ $estado_cuenta['datos_cabecera']['proyecto'] ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <td class="label">Etapa</td>
                        <td class="valor">
                            {{ $estado_cuenta['datos_cabecera']['etapa'] ?? '-' }}
                        </td>

                        <td class="label">Manzana - Lote</td>
                        <td class="valor">
                            {{ $estado_cuenta['datos_cabecera']['manzana'] ?? '-' }}
                            -
                            {{ $estado_cuenta['datos_cabecera']['lote'] ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <td class="label">Nombre Cliente</td>
                        <td class="valor" colspan="3">
                            {{ $estado_cuenta['datos_cabecera']['nombre_cliente'] ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <td class="label">DNI</td>
                        <td class="valor">
                            {{ $estado_cuenta['datos_cabecera']['dni'] ?? '-' }}
                        </td>

                        <td class="label">Fecha emisión</td>
                        <td class="valor">
                            {{ $estado_cuenta['datos_cabecera']['fecha_emision'] ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <td class="label">Precio venta</td>
                        <td class="valor">
                            S/ {{ number_format((float)str_replace(',', '',
                            $estado_cuenta['datos_cabecera']['precio_venta'] ?? 0), 2) }}
                        </td>

                        <td class="label">Inicial pagado</td>
                        <td class="valor">
                            S/ {{ number_format((float)str_replace(',', '',
                            $estado_cuenta['datos_cabecera']['inicial_pagado'] ?? 0), 2) }}
                        </td>
                    </tr>

                    <tr>
                        <td class="label">Importe financiado</td>
                        <td class="valor">
                            S/ {{ number_format((float)str_replace(',', '',
                            $estado_cuenta['datos_cabecera']['importe_financiado'] ?? 0), 2) }}
                        </td>

                        <td class="label">Importe amortizado</td>
                        <td class="valor">
                            S/ {{ number_format((float)str_replace(',', '',
                            $estado_cuenta['datos_cabecera']['importe_amortizado'] ?? 0), 2) }}
                        </td>
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
                            <th>Pen.</th>
                            <th>Días Atra.</th>
                            <th>Total</th>
                            <th>Boleta</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($estado_cuenta['detalle_cuotas'] as $item)
                        <tr>
                            <td>{{ $item['NroCuota'] ?? '-' }}</td>

                            <td>
                                {{ $item['fecha_vencimiento'] ?? '-' }}
                            </td>

                            <td>
                                S/ {{ number_format((float)($item['Montocuota'] ?? 0), 2) }}
                            </td>

                            <td>
                                S/ {{ number_format((float)($item['monto_amortizado'] ?? 0), 2) }}
                            </td>

                            <td>
                                S/ {{ number_format((float)str_replace(',', '', $item['saldo'] ?? 0), 2) }}
                            </td>

                            <td>
                                S/ {{ number_format((float)($item['penalidad'] ?? 0), 2) }}
                            </td>

                            <td>
                                {{ $item['dias_atraso'] ?? 0 }}
                            </td>

                            <td>
                                S/ {{ number_format((float)($item['total'] ?? 0), 2) }}
                            </td>

                            <td>
                                @if (!empty($item['Comprobante']))
                                <a href="{{ route('comprobante.ver', ['empresa' => $lote['id_empresa'], 'comprobante' => $item['Comprobante']]) }}"
                                    target="_blank" class="g_boton g_boton_empresa_secundario">
                                    <i class="fas fa-file-invoice-dollar"></i>
                                </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>