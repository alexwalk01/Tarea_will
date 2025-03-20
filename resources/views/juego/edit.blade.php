@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg p-4">
        <h1 class="text-center text-primary mb-4">Editar Juego</h1>

        <form method="POST" action="{{ route('juegos.update', $juego->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nombre" class="form-label fw-bold">Nombre del Juego</label>
                <input type="text" class="form-control" name="nombre" value="{{ old('nombre', $juego->nombre) }}" required>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label fw-bold">Descripción</label>
                <textarea class="form-control" name="descripcion" rows="4" required>{{ old('descripcion', $juego->descripcion) }}</textarea>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
        </form>
    </div>
</div>
@endsection
