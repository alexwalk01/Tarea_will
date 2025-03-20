@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-warning text-white d-flex align-items-center">
            <i class="bi bi-pencil-square me-2"></i>
            <h3 class="mb-0">Editar Materia</h3>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('materias.update', $materia->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre de la Materia</label>
                    <input type="text" class="form-control" name="nombre" value="{{ old('nombre', $materia->nombre) }}" required>
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" name="descripcion">{{ old('descripcion', $materia->descripcion) }}</textarea>
                </div>

                <button type="submit" class="btn btn-warning w-100">
                    <i class="bi bi-arrow-repeat"></i> Actualizar
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
