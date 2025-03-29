@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Materia</h1>

    <form action="{{ route('admin.materias.update', $materia->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $materia->nombre }}" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required>{{ $materia->descripcion }}</textarea>
        </div>

        <div class="mb-3">
            <label for="usuario_id" class="form-label">Usuario Asignado</label>
            <select class="form-select" id="usuario_id" name="usuario_id" required>
                @foreach($usuarios as $usuario)
                    <option value="{{ $usuario->id }}" {{ $materia->user_id == $usuario->id ? 'selected' : '' }}>{{ $usuario->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('admin.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
