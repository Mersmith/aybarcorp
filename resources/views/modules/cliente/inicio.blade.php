@extends('layouts.cliente.layout-cliente')

@section('titulo', 'Inicio Cliente')

@section('contenidoCliente')
    @livewire('cliente.perfil.perfil-ver-livewire')
@endsection
