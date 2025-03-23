@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Incluir el sidebar -->
        @include('layouts._sidebar')

        <!-- Contenido principal -->
        <main class="col-12 col-md-9 col-lg-10 content">
            <h1>Juegos</h1>

            <!-- Botón para agregar juegos (solo si el usuario tiene permiso) -->
            @if(in_array('create', json_decode(auth()->user()->juegos_permissions, true) ?? []))
                <a href="{{ route('juegos.create') }}" class="btn btn-success mb-3">Agregar Juego</a>
            @endif

            <div class="row">
                @foreach($juegos as $juego)
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">
                                    @if(in_array('read', json_decode(auth()->user()->juegos_permissions, true) ?? []))
                                        <a href="{{ route('juego.descripcion', $juego->id) }}" class="text-decoration-none">{{ $juego->nombre }}</a>
                                    @else
                                        {{ $juego->nombre }}
                                    @endif
                                </h5>

                                <!-- Botones de Editar y Eliminar -->
                                @if(in_array('update', json_decode(auth()->user()->juegos_permissions, true) ?? []))
                                    <a href="{{ route('juegos.edit', $juego->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                @endif
                                @if(in_array('delete', json_decode(auth()->user()->juegos_permissions, true) ?? []))
                                    <form action="{{ route('juegos.destroy', $juego->id) }}" method="POST" style="display:inline;">
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
