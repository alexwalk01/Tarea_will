@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('layouts._sidebar') <!-- Incluir el sidebar -->

        <main class="col-12 col-md-9 col-lg-10 content">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('menu.index') }}">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Proyectos</li>
                </ol>
            </nav>

            <!-- Botón para agregar proyectos (solo si el usuario tiene permiso) -->
            @if(in_array('create', json_decode(auth()->user()->proyectos_permissions, true) ?? []))
                <a href="{{ route('proyectos.create') }}" class="btn btn-success mb-3">Agregar Proyecto</a>
            @endif

            <div class="row">
                @foreach($proyectos as $proyecto)
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">
                                    @if(in_array('read', json_decode(auth()->user()->proyectos_permissions, true) ?? []))
                                        <a href="{{ route('proyecto.descripcion', $proyecto->id) }}" class="text-decoration-none">{{ $proyecto->nombre }}</a>
                                    @else
                                        {{ $proyecto->nombre }}
                                    @endif
                                </h5>
                                <p class="card-text">{{ $proyecto->descripcion ?? 'Sin descripción' }}</p>

                                <!-- Botones de Editar y Eliminar -->
                                @if(in_array('update', json_decode(auth()->user()->proyectos_permissions, true) ?? []))
                                    <a href="{{ route('proyectos.edit', $proyecto->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                @endif
                                @if(in_array('delete', json_decode(auth()->user()->proyectos_permissions, true) ?? []))
                                    <form action="{{ route('proyectos.destroy', $proyecto->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </main>
    </div>
</div>
@endsection
