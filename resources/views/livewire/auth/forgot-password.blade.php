@extends('layouts.web.layout-web')

@section('titulo', 'Recuperar contraseña')

@section('contenido')

<div class="contenedor_login">
    <div class="contenedor_login_imagen">
        <!--IMAGEN-->
        <img src="{{ asset('assets/imagen/construccion-aybar-corp.jpg') }}" alt="" />
    </div>

    <div class="contenedor_login_formulario">
        <div class="login_formulario_centrar">

            <div class="login_formulario_logo">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('assets/imagen/logo-aybar-corp-verde.png') }}" alt="">
                </a>
            </div>

            <h1 class="titulo_formulario">Recuperar contraseña</h1>

            <p class="descripcion_formulario">Ingresa tu correo electrónico y te enviaremos un enlace para restablecer
                tu contraseña.</p>

            <div class="g_gap_pagina g_margin_top_40">

                @if (session('status'))
                <div class="g_alerta_succes">
                    <i class="fa-solid fa-circle-check"></i>
                    {{ session('status') }}
                </div>
                @endif

                @if ($errors->any())
                <div class="g_alerta_error">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li><i class="fa-solid fa-triangle-exclamation"></i> {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="formulario_flex formulario">
                    @csrf

                    <div class="g_margin_top_20">
                        <label for="email">Correo electrónico</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus>
                        @error('email')
                        <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="g_margin_top_20 formulario_botones centrar">
                        <button type="submit" class="guardar" onclick="this.disabled=true; this.form.submit();">
                            Enviar enlace
                        </button>
                    </div>

                    <a href="{{ route('login') }}" class="recuperar_clave">
                        <span>¿Recordaste tu contraseña?</span>
                        Inicia sesión
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection