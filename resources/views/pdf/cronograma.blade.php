<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
        }

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
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <h2>CRONOGRAMA DE PAGOS</h2>

    <table>
        <tr>
            <th style="width: 25%;">Proyecto</th>
            <td colspan="3">{{ $lote['descripcion'] }}</td>
        </tr>

        <tr>
            <th>Etapa</th>
            <td style="width: 25%;">{{ $lote['etapa'] ?? '01' }}</td>

            <th>Manzana - Lote</th>
            <td>{{ $lote['id_manzana'] }} - {{ $lote['id_lote'] }}</td>
        </tr>

        <tr>
            <th>Nombre Cliente</th>
            <td colspan="3">{{ $lote['apellidos_nombres'] }}</td>
        </tr>

        <tr>
            <th>DNI</th>
            <td>{{ $lote['nit'] }}</td>

            <th>Código pago</th>
            <td>{{ $lote['id_recaudo'] }}</td>
        </tr>

        <tr>
            <th>N° Cuotas</th>
            <td>{{ count($cronograma) }}</td>

            <th>Cuotas pagadas</th>
            <td>{{ $total_pagados ?? '---' }}</td>
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
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cronograma as $item)
            <tr>
                <td>{{ $item['cuota'] }}</td>
                <td>{{ $item['fec_vencimiento'] }}</td>
                <td>S/ {{ number_format($item['monto'], 2) }}</td>
                <td>S/ {{ number_format($item['amortizacion'], 2) }}</td>
                <td>S/ {{ number_format($item['saldo'], 2) }}</td>
                <td>{{ $item['estado'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>