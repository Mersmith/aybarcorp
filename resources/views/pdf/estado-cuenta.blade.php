@extends('pdf.membrete.membrete')

@section('content')

<style>
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    th,
    td {
        border: 1px solid #444;
        padding: 5px;
        text-align: left;
    }

    th {
        background: #f2f2f2;
        font-weight: bold;
    }

    h2 {
        text-align: center;
        margin-bottom: 15px;
    }
</style>
<h2>ESTADO DE CUENTA</h2>

<table>
    <tr>
        <th style="width:25%;">Proyecto</th>
        <td colspan="3">{{ $estado_cuenta['Proyecto'] ?? '-' }}</td>
    </tr>

    <tr>
        <th>Etapa</th>
        <td>{{ $estado_cuenta['Etapa'] ?? '-' }}</td>

        <th>Manzana - Lote</th>
        <td>
            {{ $estado_cuenta['Manzana'] ?? '-' }}
            -
            {{ $estado_cuenta['Lote'] ?? '-' }}
        </td>
    </tr>

    <tr>
        <th>Nombre Cliente</th>
        <td colspan="3">
            {{ $estado_cuenta['Cliente'] ?? '-' }}
        </td>
    </tr>

    <tr>
        <th>DNI</th>
        <td>{{ $estado_cuenta['DNI'] ?? '-' }}</td>

        <th>Fecha emisión</th>
        <td>{{ $estado_cuenta['FecEmision'] ?? '-' }}</td>
    </tr>

    <tr>
        <th>Precio venta</th>
        <td>S/ {{ number_format((float)str_replace(',', '',
            $estado_cuenta['Venta'] ?? 0), 2) }}</td>

        <th>Inicial pagado</th>
        <td>S/ {{ number_format((float)str_replace(',', '',
            $estado_cuenta['Inicial'] ?? 0), 2) }}</td>
    </tr>

    <tr>
        <th>Importe financiado</th>
        <td>S/ {{ number_format((float)str_replace(',', '',
            $estado_cuenta['ImporteFinanciado'] ?? 0), 2) }}</td>

        <th>Capital Abonado</th>
        <td>S/ {{ number_format((float)str_replace(',', '',
            $estado_cuenta['CapitalAbonado'] ?? 0), 2) }}</td>
    </tr>
</table>

<table>
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
        </tr>
    </thead>
    <tbody>
        @foreach (($estado_cuenta['Cuotas'] ?? []) as $item)
        <tr>
            <td>{{ $item['NroCuota'] ?? '-' }}</td>
            <td>{{ $item['FecVencimiento'] ?? '-' }}</td>
            <td>S/ {{ number_format((float)($item['Cuota'] ?? 0), 2) }}</td>
            <td>S/ {{ number_format((float)str_replace(',', '', $item['CuotaPagada'] ?? 0), 2) }}</td>
            <td>S/ {{ number_format((float)str_replace(',', '', $item['SaldoPendiente'] ?? 0), 2) }}</td>
            <td>S/ {{ number_format((float)($item['Penalidad'] ?? 0), 2) }}</td>
            <td>{{ $item['DiasAtraso'] ?? 0 }}</td>
            <td>S/ {{ number_format((float)($item['Total'] ?? 0), 2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection