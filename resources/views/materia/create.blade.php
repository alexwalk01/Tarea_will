@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Agregar Nueva Materia</h1>

    <form method="POST" action="{{ route('materias.store') }}">
        @csrf
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre de la Materia</label>
            <input type="text" class="form-control" name="nombre" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" name="descripcion"></textarea>
        </div>

        <div class="mb-3">
            <label for="user_id" class="form-label">Asignar Usuario</label>
            <select name="user_id" class="form-control" required>
                @foreach($usuarios as $usuario)
                    <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>
@endsection
