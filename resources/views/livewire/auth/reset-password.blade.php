@extends('layouts.web.layout-web')

@section('titulo', 'Restablecer contraseña')

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

            <h1 class="titulo_formulario">RESTABLECER CONTRASEÑA</h1>

            <p class="descripcion_formulario">Ingrese su nueva contraseña para continuar.</p>

            @if (session('status'))
            <div class="g_alerta_succes">
                <i class="fa-solid fa-circle-check"></i>
                {{ session('status') }}
            </div>
            @endif

            @if ($errors->any())
            <div class="g_alerta_error">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <div>
                    <strong>Por favor corrige los siguientes errores:</strong>
                    {{-- <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul> --}}
                </div>
            </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}" class="formulario_flex formulario">
                @csrf

                <input type="hidden" name="token" value="{{ request()->route('token') }}">

                <div class="g_margin_top_20">
                    <label for="email">Correo electrónico</label>
                    <input id="email" name="email" type="email" value="{{ request('email') }}" required>
                    @error('email')
                    <div class="mensaje_error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="g_margin_top_20">
                    <label for="password">Nueva contraseña</label>
                    <input id="password" name="password" type="password" required>
                    @error('password')
                    <div class="mensaje_error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="g_margin_top_20">
                    <label for="password_confirmation">Confirmar contraseña</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required>
                    @error('password_confirmation')
                    <div class="mensaje_error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="g_margin_top_20 formulario_botones centrar">
                    <button type="submit" class="guardar">
                        Restablecer
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

@endsection