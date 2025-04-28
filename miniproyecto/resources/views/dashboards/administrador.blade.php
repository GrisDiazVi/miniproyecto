@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Panel de Administrador</h1>
    <p>Aquí puedes gestionar pedidos y actualizar inventario.</p>
    <a href="{{ route('usuarios.index') }}" class="btn btn-primary">Administrar Usuarios</a>
    <a href="#" class="btn btn-primary">Gestionar pedidos</a>
    <a href="#" class="btn btn-primary">Actualizar productos</a>
</div>
@endsection