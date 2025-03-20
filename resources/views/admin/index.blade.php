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
        <form action="{{ route('admin.updatePermissions', $usuario->id) }}" method="POST">
            @csrf
            <div class="form-check">
                @php
                    $juegosPermissions = json_decode($usuario->juegos_permissions, true) ?? [];
                    $materiasPermissions = json_decode($usuario->materias_permissions, true) ?? [];
                    $proyectosPermissions = json_decode($usuario->proyectos_permissions, true) ?? [];
                @endphp

                <input type="checkbox" name="juegos_permissions[]" value="create" {{ in_array('create', $juegosPermissions) ? 'checked' : '' }}> Crear Juegos
                <input type="checkbox" name="juegos_permissions[]" value="read" {{ in_array('read', $juegosPermissions) ? 'checked' : '' }}> Leer Juegos
                <input type="checkbox" name="juegos_permissions[]" value="update" {{ in_array('update', $juegosPermissions) ? 'checked' : '' }}> Actualizar Juegos
                <input type="checkbox" name="juegos_permissions[]" value="delete" {{ in_array('delete', $juegosPermissions) ? 'checked' : '' }}> Eliminar Juegos
            </div>
            <div class="form-check">
                <input type="checkbox" name="materias_permissions[]" value="create" {{ in_array('create', $materiasPermissions) ? 'checked' : '' }}> Crear Materias
                <input type="checkbox" name="materias_permissions[]" value="read" {{ in_array('read', $materiasPermissions) ? 'checked' : '' }}> Leer Materias
                <input type="checkbox" name="materias_permissions[]" value="update" {{ in_array('update', $materiasPermissions) ? 'checked' : '' }}> Actualizar Materias
                <input type="checkbox" name="materias_permissions[]" value="delete" {{ in_array('delete', $materiasPermissions) ? 'checked' : '' }}> Eliminar Materias
            </div>
            <div class="form-check">
                <input type="checkbox" name="proyectos_permissions[]" value="create" {{ in_array('create', $proyectosPermissions) ? 'checked' : '' }}> Crear Proyectos
                <input type="checkbox" name="proyectos_permissions[]" value="read" {{ in_array('read', $proyectosPermissions) ? 'checked' : '' }}> Leer Proyectos
                <input type="checkbox" name="proyectos_permissions[]" value="update" {{ in_array('update', $proyectosPermissions) ? 'checked' : '' }}> Actualizar Proyectos
                <input type="checkbox" name="proyectos_permissions[]" value="delete" {{ in_array('delete', $proyectosPermissions) ? 'checked' : '' }}> Eliminar Proyectos
            </div>
            <button type="submit" class="btn btn-primary mt-2">Actualizar Permisos</button>
        </form>
    </li>
@endforeach
            </ul>
        </div>
    </div>

    <!-- Secciones de Juegos, Materias y Proyectos -->
    <div class="card mb-4">
        <div class="card-header">
            <h2 class="card-title">Juegos</h2>
        </div>
        <div class="card-body">
            <ul class="list-group">
                @foreach($juegos as $juego)
                    <li class="list-group-item">
                        {{ $juego->nombre }}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h2 class="card-title">Materias</h2>
        </div>
        <div class="card-body">
            <ul class="list-group">
                @foreach($materias as $materia)
                    <li class="list-group-item">
                        {{ $materia->nombre }}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h2 class="card-title">Proyectos</h2>
        </div>
        <div class="card-body">
            <ul class="list-group">
                @foreach($proyectos as $proyecto)
                    <li class="list-group-item">
                        {{ $proyecto->nombre }}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
