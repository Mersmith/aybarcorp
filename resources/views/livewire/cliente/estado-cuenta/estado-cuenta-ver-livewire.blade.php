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
                        <td class="valor"> {{ $estado_cuenta['DNI'] ?? '-' }} </td>

                        <td class="label">Fecha emisión</td>
                        <td class="valor"> {{ $estado_cuenta['FecEmision'] ?? '-' }}</td>
                    </tr>

                    <tr>
                        <td class="label">Precio Venta</td>
                        <td class="valor">S/ {{ $estado_cuenta['Venta'] ?? '-' }}</td>

                        <td class="label">Impor. Financiado</td>
                        <td class="valor">S/ {{ $estado_cuenta['ImporteFinanciado'] ?? '-' }}</td>
                    </tr>

                    <tr>
                        <td class="label">Inicial</td>
                        <td class="valor">S/ {{ $estado_cuenta['Inicial'] ?? '-' }}</td>

                        <td class="label">Exonerada</td>
                        <td class="valor">S/ {{ $estado_cuenta['Exonerado'] ?? '-' }}</td>
                    </tr>

                    <tr>
                        <td class="label">Capital abonado</td>
                        <td class="valor">S/ {{ $estado_cuenta['CapitalAbonado'] ?? '-' }}</td>

                        <td class="label">Penalidad abonado</td>
                        <td class="valor"></td>
                    </tr>

                    <tr>
                        <td class="label">Saldo total pend.</td>
                        <td class="valor">S/ {{ $estado_cuenta['SaldoTotalPendiente'] ?? '-' }}</td>

                        <td class="label">Saldo capital pend.</td>
                        <td class="valor">S/ {{ $estado_cuenta['SaldoCapitalPendiente'] ?? '-' }}</td>
                    </tr>

                    <tr>
                        <td class="label">Ult. Edición</td>
                        <td class="valor">S/ {{ $estado_cuenta['UltimaEdicion'] ?? '-' }}</td>

                        <td class="label">N° Cuotas pend.</td>
                        <td class="valor">S/ {{ $estado_cuenta['NroCuotasPendiente'] ?? '-' }}</td>
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
                            <th>Fecha Comp.</th>
                            {{-- <th>Días Atra.</th> --}}
                            <th>Cuota</th>
                            {{-- <th>Pen.</th> --}}
                            <th>Total</th>
                            <th>Comp.</th>
                            <th>Cuo. Pagado</th>
                            {{-- <th>Pen. Pagado</th> --}}
                            <th>Pend.</th>
                            <th>Boleta</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach (($estado_cuenta['Cuotas'] ?? []) as $item)
                        <tr>
                            <td>{{ $item['NroCuota'] ?? '-' }}</td>
                            <td>{{ $item['FecVencimiento'] ?? '-' }}</td>
                            <td>{{ $item['FecCompra'] ?? '-' }}</td>
                            {{-- <td> {{ $item['DiasAtraso'] ?? 0 }}</td> --}}
                            <td> S/ {{ $item['Cuota'] ?? 0 }}</td>
                            {{-- <td> S/ {{ $item['Penalidad'] ?? 0 }}</td> --}}
                            <td>S/ {{ $item['Total'] ?? 0 }}</td>
                            <td>S/ {{ $item['MontoComp'] ?? 0 }}</td>
                            <td>S/ {{ $item['CuotaPagada'] ?? 0 }}</td>
                            {{-- <td>S/ {{ $item['PenalPagada'] ?? 0 }}</td> --}}
                            <td>S/ {{ $item['SaldoPendiente'] ?? 0 }}</td>
                            <td>
                                @if (!empty($item['Comprobante']))

                                @if (substr_count($item['Comprobante'], '-') === 2)
                                <a href="{{ route('comprobante.ver', [ 'empresa' => $lote['id_empresa'], 'comprobante' => $item['Comprobante'] ]) }}"
                                    target="_blank" class="g_boton g_boton_empresa_secundario">
                                    <i class="fas fa-file-invoice-dollar"></i>
                                </a>
                                @else
                                <x-tooltip text="Tu comprante esta siendo migrado!" />

                                <span class="g_boton g_boton_empresa_primario"
                                    style="cursor: not-allowed; pointer-events: none;">
                                    <i class="fas fa-file-invoice-dollar"></i>
                                </span>
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
</div>