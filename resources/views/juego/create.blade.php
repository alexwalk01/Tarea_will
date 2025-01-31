@extends('layouts.app')

@section('content')
<div class="container">
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

    <h1>Agregar Juego</h1>

    <form method="POST" action="{{ route('juegos.store') }}">
        @csrf
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Juego</label>
            <input type="text" class="form-control" name="nombre" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" name="descripcion" required></textarea>
        </div>

        <div class="mb-3">
            <label for="usuario_id" class="form-label">Asignar a Usuario</label>
            <select name="usuario_id" class="form-control">
                @foreach($usuarios as $usuario)
                    <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                @endforeach
            </select>


        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>
@endsection
