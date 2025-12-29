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

    <h2>ESTADO CUENTA</h2>

    <table width="100%" cellpadding="6" cellspacing="0" border="1">
        <tr>
            <th style="width: 25%;">Proyecto</th>
            <td colspan="3">
                {{ $estado_cuenta['datos_cabecera']['proyecto'] ?? '-' }}
            </td>
        </tr>

        <tr>
            <th>Etapa</th>
            <td style="width: 25%;">
                {{ $estado_cuenta['datos_cabecera']['etapa'] ?? '-' }}
            </td>

            <th>Manzana - Lote</th>
            <td>
                {{ $estado_cuenta['datos_cabecera']['manzana'] ?? '-' }}
                -
                {{ $estado_cuenta['datos_cabecera']['lote'] ?? '-' }}
            </td>
        </tr>

        <tr>
            <th>Nombre Cliente</th>
            <td colspan="3">
                {{ $estado_cuenta['datos_cabecera']['nombre_cliente'] ?? '-' }}
            </td>
        </tr>

        <tr>
            <th>DNI</th>
            <td>
                {{ $estado_cuenta['datos_cabecera']['dni'] ?? '-' }}
            </td>

            <th>Fecha emisión</th>
            <td>
                {{ $estado_cuenta['datos_cabecera']['fecha_emision'] ?? '-' }}
            </td>
        </tr>

        <tr>
            <th>Precio venta</th>
            <td>
                S/ {{
                number_format(
                (float) str_replace(',', '',
                $estado_cuenta['datos_cabecera']['precio_venta'] ?? 0),
                2)
                }}
            </td>

            <th>Inicial pagado</th>
            <td>
                S/ {{
                number_format(
                (float) str_replace(',', '',
                $estado_cuenta['datos_cabecera']['inicial_pagado'] ?? 0),
                2)
                }}
            </td>
        </tr>

        <tr>
            <th>Importe financiado</th>
            <td>
                S/ {{
                number_format(
                (float) str_replace(',', '',
                $estado_cuenta['datos_cabecera']['importe_financiado'] ?? 0),
                2)
                }}
            </td>

            <th>Importe amortizado</th>
            <td>
                S/ {{
                number_format(
                (float) str_replace(',', '',
                $estado_cuenta['datos_cabecera']['importe_amortizado'] ?? 0),
                2)
                }}
            </td>
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
                <th>Pen.</th>
                <th>Días Atra.</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($estado_cuenta['detalle_cuotas'] as $item)
            <tr>
                <td>{{ $item['NroCuota'] }}</td>
                <td>{{ $item['fecha_vencimiento'] }}</td>
                <td>S/ {{ number_format((float)($item['Montocuota'] ?? 0), 2) }}</td>
                <td>S/ {{ number_format((float)($item['monto_amortizado'] ?? 0), 2) }}</td>
                <td>S/ {{ number_format((float)str_replace(',', '', $item['saldo'] ?? 0), 2) }}</td>
                <td>S/ {{ number_format((float)($item['penalidad'] ?? 0), 2) }}</td>
                <td>{{ $item['dias_atraso'] ?? 0 }}</td>
                <td>S/ {{ number_format((float)($item['total'] ?? 0), 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>