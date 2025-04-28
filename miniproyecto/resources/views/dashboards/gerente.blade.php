@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Panel de Gerente</h1>
    <p>Aquí puedes administrar empleados, estadísticas y configuración general.</p>
    <a href="{{ route('usuarios.index') }}" class="btn btn-primary">Administrar Usuarios</a>
    <a href="#" class="btn btn-primary">Ver estadísticas</a>
    <a href="#" class="btn btn-primary">Configuración</a>
</div>
@endsection