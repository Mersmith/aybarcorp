@extends('layouts.cliente.layout-cliente')

@section('titulo', 'Inicio Cliente')

@section('contenidoCliente')

<div class="g_gap_pagina">
    @livewire('cliente.perfil.perfil-ver-livewire')

    @livewire('cliente.direccion.direccion-editar-livewire')

    @livewire('cliente.cuenta.cuenta-editar-livewire')
</div>
@endsection