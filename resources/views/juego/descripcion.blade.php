@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('layouts._sidebar')

        <main class="col-12 col-md-9 col-lg-10 content">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('menu.index') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('juego.index') }}">Juegos</a></li>
                    <li class="breadcrumb-item active">{{ $juego->nombre }}</li>
                </ol>
            </nav>

            <div class="container">
                <h2>{{ $juego->nombre }}</h2>
                <p>{{ $juego->descripcion }}</p>
                <a href="{{ route('menu.index') }}">Volver al menú</a>
            </div>
        </main>
    </div>
</div>
@endsection
