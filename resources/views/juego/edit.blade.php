@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Juego</h1>

    <form method="POST" action="{{ route('juegos.update', $juego->id) }}">
        @csrf
        @method('PUT') <!-- Método PUT para actualizar el recurso -->

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Juego</label>
            <input type="text" class="form-control" name="nombre" value="{{ old('nombre', $juego->nombre) }}" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" name="descripcion">{{ old('descripcion', $juego->descripcion) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>
@endsection
