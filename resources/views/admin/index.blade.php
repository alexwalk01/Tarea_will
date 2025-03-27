@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-center">Panel de Administración</h1>

    <!-- Sección de Usuarios -->
    <div class="card mb-4">
        <div class="card-header">
            <h2 class="card-title">Usuarios</h2>
            <div class="text-center mb-4">
                <a href="{{ route('admin.register') }}" class="btn btn-success">Registrar Nuevo Usuario</a>
            </div>
        </div>
        <div class="card-body">
            <ul class="list-group">
                @foreach($usuarios as $usuario)
                    <li class="list-group-item">
                        <strong>{{ $usuario->name }}</strong> ({{ $usuario->email }}) - Rol: {{ $usuario->role }}

                        <!-- Formulario de permisos -->
                        <form action="{{ route('admin.updatePermissions', $usuario->id) }}" method="POST" class="my-3">
                            @csrf
                            <div class="mb-3">
                                <h6>Permisos de Juegos:</h6>
                                @php
                                    $juegosPermissions = json_decode($usuario->juegos_permissions, true) ?? [];
                                @endphp
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="juegos_permissions[]" value="create" {{ in_array('create', $juegosPermissions) ? 'checked' : '' }}>
                                    <label class="form-check-label">Crear</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="juegos_permissions[]" value="read" {{ in_array('read', $juegosPermissions) ? 'checked' : '' }}>
                                    <label class="form-check-label">Leer</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="juegos_permissions[]" value="update" {{ in_array('update', $juegosPermissions) ? 'checked' : '' }}>
                                    <label class="form-check-label">Actualizar</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="juegos_permissions[]" value="delete" {{ in_array('delete', $juegosPermissions) ? 'checked' : '' }}>
                                    <label class="form-check-label">Eliminar</label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <h6>Permisos de Materias:</h6>
                                @php
                                    $materiasPermissions = json_decode($usuario->materias_permissions, true) ?? [];
                                @endphp
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="materias_permissions[]" value="create" {{ in_array('create', $materiasPermissions) ? 'checked' : '' }}>
                                    <label class="form-check-label">Crear</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="materias_permissions[]" value="read" {{ in_array('read', $materiasPermissions) ? 'checked' : '' }}>
                                    <label class="form-check-label">Leer</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="materias_permissions[]" value="update" {{ in_array('update', $materiasPermissions) ? 'checked' : '' }}>
                                    <label class="form-check-label">Actualizar</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="materias_permissions[]" value="delete" {{ in_array('delete', $materiasPermissions) ? 'checked' : '' }}>
                                    <label class="form-check-label">Eliminar</label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <h6>Permisos de Proyectos:</h6>
                                @php
                                    $proyectosPermissions = json_decode($usuario->proyectos_permissions, true) ?? [];
                                @endphp
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="proyectos_permissions[]" value="create" {{ in_array('create', $proyectosPermissions) ? 'checked' : '' }}>
                                    <label class="form-check-label">Crear</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="proyectos_permissions[]" value="read" {{ in_array('read', $proyectosPermissions) ? 'checked' : '' }}>
                                    <label class="form-check-label">Leer</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="proyectos_permissions[]" value="update" {{ in_array('update', $proyectosPermissions) ? 'checked' : '' }}>
                                    <label class="form-check-label">Actualizar</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="proyectos_permissions[]" value="delete" {{ in_array('delete', $proyectosPermissions) ? 'checked' : '' }}>
                                    <label class="form-check-label">Eliminar</label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Actualizar Permisos</button>
                        </form>

                        <!-- Botón para eliminar usuario (dispara el modal) -->
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $usuario->id }}">
                            Eliminar Usuario
                        </button>
                    </li>

                    <!-- Modal de confirmación para cada usuario -->
                    <div class="modal fade" id="deleteModal-{{ $usuario->id }}" tabindex="-1" aria-labelledby="deleteModalLabel-{{ $usuario->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel-{{ $usuario->id }}">Confirmar Eliminación</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    ¿Estás seguro de que deseas eliminar al usuario <strong>{{ $usuario->name }}</strong>? Esta acción no se puede deshacer.
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <form action="{{ route('admin.deleteUser', $usuario->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Confirmar Eliminación</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Sección de Juegos -->
    <div class="card mb-4">
        <div class="card-header">
            <h2 class="card-title">Juegos</h2>
        </div>
        <div class="card-body">
            <ul class="list-group">
                @foreach($juegos as $juego)
                    <li class="list-group-item">{{ $juego->nombre }}</li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Sección de Materias -->
    <div class="card mb-4">
        <div class="card-header">
            <h2 class="card-title">Materias</h2>
        </div>
        <div class="card-body">
            <ul class="list-group">
                @foreach($materias as $materia)
                    <li class="list-group-item">{{ $materia->nombre }}</li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Sección de Proyectos -->
    <div class="card mb-4">
        <div class="card-header">
            <h2 class="card-title">Proyectos</h2>
        </div>
        <div class="card-body">
            <ul class="list-group">
                @foreach($proyectos as $proyecto)
                    <li class="list-group-item">{{ $proyecto->nombre }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@endsection
