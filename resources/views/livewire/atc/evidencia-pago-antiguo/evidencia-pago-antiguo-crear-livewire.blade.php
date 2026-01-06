@section('tituloPagina', 'Crear evidencia pago antiguo')
@section('anchoPantalla', '100%')

<div class="g_gap_pagina">

    <div class="g_panel cabecera_titulo_pagina">
        <h2>Crear evidencia pago stock</h2>

        <div class="cabecera_titulo_botones">
            <a href="{{ route('admin.evidencia-pago-antiguo.vista.todo') }}" class="g_boton g_boton_light">
                Inicio <i class="fa-solid fa-house"></i>
            </a>

            <a href="{{ route('admin.evidencia-pago-antiguo.vista.todo') }}" class="g_boton g_boton_darkt">
                <i class="fa-solid fa-arrow-left"></i> Regresar
            </a>
        </div>
    </div>

    <div class="formulario g_gap_pagina"> </div>
</div>
