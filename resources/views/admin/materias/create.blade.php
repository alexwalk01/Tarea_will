@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-book"></i> Crear Nueva Materia
                    </h5>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('materias.store') }}">
                        @csrf

                        <div class="mb-3 row">
                            <label for="nombre" class="col-md-4 col-form-label text-md-end">
                                Nombre de la Materia
                            </label>
                            <div class="col-md-6">
                                <input id="nombre" type="text"
                                       class="form-control @error('nombre') is-invalid @enderror"
                                       name="nombre" value="{{ old('nombre') }}"
                                       required autocomplete="off" autofocus>

                                @error('nombre')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="descripcion" class="col-md-4 col-form-label text-md-end">
                                Descripción
                            </label>
                            <div class="col-md-6">
                                <textarea id="descripcion"
                                       class="form-control @error('descripcion') is-invalid @enderror"
                                       name="descripcion" required>{{ old('descripcion') }}</textarea>

                                @error('descripcion')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="usuario_id" class="col-md-4 col-form-label text-md-end">
                                Asignar a Usuario
                            </label>
                            <div class="col-md-6">
                                <select id="usuario_id" name="usuario_id" class="form-control" required>
                                    <option value="">Seleccione un usuario</option>
                                    @foreach($usuarios as $usuario)
                                        <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Guardar Materia
                                </button>
                                <a href="{{ route('admin.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancelar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
