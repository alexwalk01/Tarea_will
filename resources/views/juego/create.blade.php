@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg p-4">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <h1 class="text-center text-success mb-4">Agregar Juego</h1>

        <form method="POST" action="{{ route('juegos.store') }}">
            @csrf

            <div class="mb-3">
                <label for="nombre" class="form-label fw-bold">Nombre del Juego</label>
                <input type="text" class="form-control" name="nombre" required>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label fw-bold">Descripción</label>
                <textarea class="form-control" name="descripcion" rows="4" required></textarea>
            </div>

            <div class="mb-3">
                <label for="usuario_id" class="form-label fw-bold">Asignar a Usuario</label>
                <select name="usuario_id" class="form-select">
                    @foreach($usuarios as $usuario)
                        <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-success">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endsection
