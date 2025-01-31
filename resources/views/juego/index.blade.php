@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Contenido principal -->
        <main class="col-12 col-md-9 col-lg-10 content">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" id="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('menu.index') }}">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Juegos</li>
                </ol>
            </nav>

            <div class="container">
                <h2>Juegos disponibles</h2>
                @if ($juegos->isEmpty())
                    <p>No tienes juegos disponibles.</p>
                @else
                    <ul>
                        @foreach ($juegos as $juego)
                            <li>
                                <a href="{{ route('juego.descripcion', $juego->id) }}">
                                    {{ $juego->nombre }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </main>
    </div>
</div>
@endsection
