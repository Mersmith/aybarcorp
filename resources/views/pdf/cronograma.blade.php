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
<h2>CRONOGRAMA DE PAGOS</h2>

<table>
    <tr>
        <th style="width: 25%;">Proyecto</th>
        <td colspan="3">{{ $cabecera['proyecto'] ?? '-' }}</td>
    </tr>

    <tr>
        <th>Etapa</th>
        <td style="width: 25%;">{{ $cabecera['etapa'] ?? '-' }}</td>

        <th>Manzana - Lote</th>
        <td>
            {{ $cabecera['manzana'] ?? '-' }}
            -
            {{ $cabecera['lote'] ?? '-' }}
        </td>
    </tr>

    <tr>
        <th>Nombre Cliente</th>
        <td colspan="3">{{ $cabecera['nombre_cliente'] ?? '-' }}</td>
    </tr>

    <tr>
        <th>DNI</th>
        <td>{{ $cabecera['dni'] ?? '-' }}</td>

        <th>Fecha Emisión</th>
        <td>{{ $cabecera['fecha_emision'] ?? '-' }}</td>
    </tr>

    <tr>
        <th>Precio Venta</th>
        <td>S/ {{ $cabecera['precio_venta'] ?? '-' }}</td>

        <th>Impor. Financiado</th>
        <td>S/ {{ $cabecera['importe_financiado'] ?? '-' }}</td>
    </tr>

    <tr>
        <th>Inicial</th>
        <td>S/ {{ $cabecera['inicial_pagado'] ?? '-' }}</td>

        <th>Impor. Amortizado</th>
        <td>S/ {{ $cabecera['importe_amortizado'] ?? '-' }}</td>
    </tr>
</table>

<table>
    <thead>
        <tr>
            <th>Nro</th>
            <th>Fecha Venc.</th>
            <th>Cuota</th>
            <th>Mto. Amortizado</th>
            <th>Saldo</th>
            <th>Penalidad</th>
            <th>Dias Atraso</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($detalle as $item)
        <tr>
            <td>{{ $item['NroCuota'] ?? '-' }}</td>
            <td>{{ $item['fecha_vencimiento'] ?? '-' }}</td>
            <td>S/ {{ $item['Montocuota'] ?? 0}}</td>
            <td>S/ {{ $item['monto_amortizado'] ?? 0 }}</td>
            <td>S/ {{ $item['saldo'] ?? 0 }}</td>
            <td> S/ {{ $item['penalidad'] ?? 0 }}</td>
            <td>{{ $item['dias_atraso'] ?? '-' }}</td>
            <td>S/ {{ $item['total'] ?? 0 }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection