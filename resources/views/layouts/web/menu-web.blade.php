<div>
    <!-- Header -->
    <header class="web_header">
        <div class="web_header_cuerpo">

            <a href="https://aybarcorp.com/">
                <img class="logo" src="{{ asset('assets/imagen/logo-aybar-corp-blanco.png') }}" alt="Logo">
            </a>

            <!-- Botón menú móvil -->
            <button class="web_menu_toggle" @click="menuAbierto = true" aria-label="Abrir menú">
                <i class="fa-solid fa-bars"></i>
            </button>

            <!-- Menú lateral -->
            <nav class="web_nav_menu" :class="{ 'active': menuAbierto }">

                <div class="cabecera_sidebar">
                    <button class="web_menu_toggle" @click="menuAbierto = false" aria-label="Cerrar menú">
                        <i class="fa-solid fa-xmark"></i>
                    </button>

                    <a href="https://aybarcorp.com/">
                        <img class="logo" src="{{ asset('assets/imagen/logo-aybar-corp-blanco.png') }}" alt="Logo">
                    </a>
                </div>

                <ul class="menu_principal" x-data="{
                    openMenuCliente: false,
                    isDesktop: window.innerWidth >= 850
                }" x-init="window.addEventListener('resize', () => {
                    isDesktop = window.innerWidth >= 850
                })">
                    @guest
                        <li class="menu_item">
                            <a href="/ingresar" class="boton_personalizado boton_personalizado_amarillo_v2"><i
                                    class="fa-solid fa-user-circle"></i> ZONA CLIENTE
                                DIGITAL</a>
                        </li>
                    @else
                        @if (auth()->user()->rol === 'cliente')
                            <li class="menu_item">
                                <a href="{{ route('cliente.home') }}"
                                    class="boton_personalizado boton_personalizado_amarillo_v2"
                                    @click.prevent="!isDesktop ? openMenuCliente = !openMenuCliente : window.location.href = '{{ route('cliente.home') }}'">
                                    <i class="fa-solid fa-user-circle"></i>
                                    ZONA CLIENTE
                                </a>
                            </li>

                            <div x-show="openMenuCliente" x-transition @click.outside="open = false" style="display: none;"
                                class="mostrar_menu_cliente">
                                @include('layouts.cliente.menu')
                            </div>
                        @elseif (auth()->user()->rol === 'admin')
                            <li class="menu_item">
                                <a href="{{ route('admin.home') }}"
                                    class="boton_personalizado boton_personalizado_amarillo_v2">BACKOFFICE</a>
                            </li>
                        @endif
                    @endguest
                </ul>
            </nav>

            <div class="web_nav_overlay" :class="{ 'active': menuAbierto }" @click="menuAbierto = false">
            </div>

        </div>
    </header>
</div>
