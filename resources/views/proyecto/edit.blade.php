@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-info text-white d-flex align-items-center">
            <i class="bi bi-tools me-2"></i>
            <h5 class="mb-0">Editar Proyecto</h5>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @elseif($errors->any())
                <div class="alert alert-danger">Hubo un error, revisa el formulario.</div>
            @endif

            <form method="POST" action="{{ route('proyectos.update', $proyecto->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre del Proyecto</label>
                    <input type="text" class="form-control" name="nombre" value="{{ old('nombre', $proyecto->nombre) }}" required>
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" name="descripcion">{{ old('descripcion', $proyecto->descripcion) }}</textarea>
                </div>

                <button type="submit" class="btn btn-info w-100 shadow-sm">
                    <i class="bi bi-arrow-repeat me-1"></i> Actualizar
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
