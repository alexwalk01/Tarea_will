@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-center">Panel de Administración</h1>

    <!-- Sección de Usuarios -->
    <div class="card mb-4">
        <div class="card-header">
            <h2 class="card-title">Usuarios</h2>
        </div>
        <div class="card-body">
            <ul class="list-group">
                @foreach($usuarios as $usuario)
                    <li class="list-group-item">
                        <strong>{{ $usuario->name }}</strong> ({{ $usuario->email }})
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Sección de Juegos -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title mb-0">Juegos</h2>
            <a href="{{ route('juegos.create') }}" class="btn btn-success btn-sm">Agregar Juego</a>
        </div>
        <div class="card-body">
            <ul class="list-group">
                @foreach($juegos as $juego)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $juego->nombre }}
                        <a href="{{ route('juegos.edit', $juego->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Sección de Materias -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title mb-0">Materias</h2>
            <a href="{{ route('materias.create') }}" class="btn btn-success btn-sm">Agregar Materia</a>
        </div>
        <div class="card-body">
            <ul class="list-group">
                @foreach($materias as $materia)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $materia->nombre }}
                        <a href="{{ route('materias.edit', $materia->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Sección de Proyectos -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title mb-0">Proyectos</h2>
            <a href="{{ route('proyectos.create') }}" class="btn btn-success btn-sm">Agregar Proyecto</a>
        </div>
        <div class="card-body">
            <ul class="list-group">
                @foreach($proyectos as $proyecto)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $proyecto->nombre }}
                        <a href="{{ route('proyectos.edit', $proyecto->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
