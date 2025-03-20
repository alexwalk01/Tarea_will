@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white d-flex align-items-center">
            <i class="bi bi-folder-plus me-2"></i>
            <h5 class="mb-0">Agregar Nuevo Proyecto</h5>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @elseif($errors->any())
                <div class="alert alert-danger">Hubo un error, revisa el formulario.</div>
            @endif

            <form method="POST" action="{{ route('proyectos.store') }}">
                @csrf

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre del Proyecto</label>
                    <input type="text" class="form-control" name="nombre" required>
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" name="descripcion"></textarea>
                </div>

                <div class="mb-3">
                    <label for="user_id" class="form-label">Asignar Usuario</label>
                    <select name="user_id" class="form-select" required>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-success w-100 shadow-sm">
                    <i class="bi bi-save me-1"></i> Guardar
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
