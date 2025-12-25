@extends('layouts.web.layout-web')

@section('titulo', 'Verifica tu correo')

@section('contenido')

<div class="contenedor_login">

    <div class="contenedor_login_imagen">
        <!--IMAGEN-->
        <img src="{{ asset('assets/imagen/construccion-aybar-corp.jpg') }}" alt="" />
    </div>

    <div class="contenedor_login_formulario">
        <div class="login_formulario_centrar">

            <!--LOGO-->
            <div class="login_formulario_logo">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('assets/imagen/logo-aybar-corp-verde.png') }}" alt="">
                </a>
            </div>

            <h1 class="titulo_formulario">Verifique su bandeja de correo</h1>

            <p class="descripcion_formulario">Le hemos enviado un enlace para validar su cuenta.</p>

            <div class="g_gap_pagina g_margin_top_40">
                @if (session('status') == 'verification-link-sent')
                <div class="g_alerta_succes">
                    <i class="fa-solid fa-circle-check"></i>
                    <div>Hemos enviado un nuevo enlace de verificación. Revise su correo y active su cuenta.</div>
                </div>
                @endif

                @if (session('error'))
                <div class="g_alerta_error">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <div>{{ session('error') }}</div>
                </div>
                @endif

                <form method="POST" action="{{ route('verification.send') }}" class="formulario_flex formulario">
                    @csrf
                    <div class="g_margin_top_20">
                        <label>Si no recibió el link de verificación, puede reenviarlo.</label>

                        <div class="g_margin_top_20 formulario_botones centrar">
                            <button type="submit" class="guardar">
                                Reenviar verificación
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection