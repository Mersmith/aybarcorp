<div>
    <div class="cronograma_contenedor">
        <div class="tabla_contenido">
            <div class="contenedor_tabla">
                <table class="tabla_info">

                    <tr>
                        <td class="label">Proyecto</td>
                        <td class="valor grande" colspan="3">
                            {{ $estado_cuenta['Proyecto'] ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <td class="label">Etapa</td>
                        <td class="valor">
                            {{ $estado_cuenta['Etapa'] ?? '-' }}
                        </td>

                        <td class="label">Manzana - Lote</td>
                        <td class="valor">
                            {{ $estado_cuenta['Manzana'] ?? '-' }}
                            -
                            {{ $estado_cuenta['Lote'] ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <td class="label">Nombre Cliente</td>
                        <td class="valor" colspan="3">
                            {{ $estado_cuenta['Cliente'] ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <td class="label">DNI</td>
                        <td class="valor">
                            {{ $estado_cuenta['DNI'] ?? '-' }}
                        </td>

                        <td class="label">Fecha emisión</td>
                        <td class="valor">
                            {{ $estado_cuenta['FecEmision'] ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <td class="label">Precio venta</td>
                        <td class="valor">
                            S/ {{ number_format((float)str_replace(',', '',
                            $estado_cuenta['Venta'] ?? 0), 2) }}
                        </td>

                        <td class="label">Inicial pagado</td>
                        <td class="valor">
                            S/ {{ number_format((float)str_replace(',', '',
                            $estado_cuenta['Inicial'] ?? 0), 2) }}
                        </td>
                    </tr>

                    <tr>
                        <td class="label">Importe financiado</td>
                        <td class="valor">
                            S/ {{ number_format((float)str_replace(',', '',
                            $estado_cuenta['ImporteFinanciado'] ?? 0), 2) }}
                        </td>

                        <td class="label">Capital Abonado</td>
                        <td class="valor">
                            S/ {{ number_format((float)str_replace(',', '',
                            $estado_cuenta['CapitalAbonado'] ?? 0), 2) }}
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
                            <th>Pagado</th>
                            <th>Saldo</th>
                            <th>Pen.</th>
                            <th>Días Atra.</th>
                            <th>Total</th>
                            <th>Boleta</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach (($estado_cuenta['Cuotas'] ?? []) as $item)
                        <tr>
                            <td>{{ $item['NroCuota'] ?? '-' }}</td>

                            <td>
                                {{ $item['FecVencimiento'] ?? '-' }}
                            </td>

                            <td>
                                S/ {{ number_format((float)($item['Cuota'] ?? 0), 2) }}
                            </td>

                            <td>
                                S/ {{ number_format((float)str_replace(',', '', $item['CuotaPagada'] ?? 0), 2) }}
                            </td>

                            <td>
                                S/ {{ number_format((float)str_replace(',', '', $item['SaldoPendiente'] ?? 0), 2) }}
                            </td>

                            <td>
                                S/ {{ number_format((float)($item['Penalidad'] ?? 0), 2) }}
                            </td>

                            <td>
                                {{ $item['DiasAtraso'] ?? 0 }}
                            </td>

                            <td>
                                S/ {{ number_format((float)($item['Total'] ?? 0), 2) }}
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