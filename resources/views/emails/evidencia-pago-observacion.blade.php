<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Solicitud de evidencia de pago</title>
</head>

<body style="margin:0; padding:25px; font-family: Arial, sans-serif;">

    <div
        style="
    max-width:580px;
    margin:0 auto;
    background:#ffffff;
    border-radius:16px;
    padding:35px;
    color:#333333;
">

        <div style="text-align:center;">
            <img src="https://aybarcorp.com/public/logo-aybar-corp-verde.png" alt="Aybar Corp"
                style="width:160px; margin-bottom:20px;">
        </div>

        <!-- TITULO -->
        <h2 style="color:#02424e; margin-top:0; font-size:24px;">
            ¡Le informamos que su evidencia de pago!
        </h2>

        <p style="font-size:16px; line-height:1.6;">
            {{ $mensaje }}
        </p>

        <ul style="font-size:15px; line-height:1.6;">
            <li><strong>Razón Social:</strong> {{ $solicitud->razon_social }}</li>
            <li><strong>Proyecto:</strong> {{ $solicitud->nombre_proyecto }}</li>
            <li><strong>Etapa:</strong> {{ $solicitud->etapa }}</li>
            <li><strong>Lote:</strong> {{ $solicitud->lote }}</li>
            <li><strong>Manzana:</strong> {{ $solicitud->manzana }}</li>
            <li><strong>N° Cuota:</strong> {{ $solicitud->numero_cuota }}</li>
        </ul>

        <div style="text-align:center; margin:30px 0;">
            <a href="{{ route('home') }}" target="_blank"
                style="
                background-color:#02424e;
                color:#ffffff !important;
                padding:14px 28px;
                text-decoration:none;
                border-radius:10px;
                font-size:16px;
                font-weight:bold;
            ">
                Ingresar a la plataforma
            </a>
        </div>

        <!-- FOOTER -->
        <p style="font-size:15px; color:#666; margin-bottom:0;">
            Saludos,<br>
            <strong>Aybar Corp</strong>
        </p>
    </div>

</body>

</html>
