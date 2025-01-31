@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Proyecto</h1>

    <form method="POST" action="{{ route('proyectos.update', $proyecto->id) }}">
        @csrf
        @method('PUT') <!-- Método PUT para actualizar el recurso -->

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Proyecto</label>
            <input type="text" class="form-control" name="nombre" value="{{ old('nombre', $proyecto->nombre) }}" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" name="descripcion">{{ old('descripcion', $proyecto->descripcion) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>
@endsection
