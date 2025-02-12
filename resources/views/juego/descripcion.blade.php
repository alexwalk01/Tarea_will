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
                <form action="{{ route('buscar.general') }}" method="GET" style="position: fixed; top: 20%; right: 10px; z-index: 1000; display: flex; gap: 10px; align-items: center; transform: translateY(-50%);">
                <select name="categoria" style="padding: 5px; font-size: 14px;">
                    <option value="juegos" {{ request('categoria') == 'juegos' ? 'selected' : '' }}>Juegos</option>
                    <option value="materias" {{ request('categoria') == 'materias' ? 'selected' : '' }}>Materias</option>
                    <option value="proyectos" {{ request('categoria') == 'proyectos' ? 'selected' : '' }}>Proyectos</option>
                </select>
                <input required type="text" name="nombre" placeholder="Buscar..." value="{{ request('nombre') }}" style="padding: 5px; font-size: 14px;">
                <button type="submit" style="padding: 5px 10px; font-size: 14px; cursor: pointer;">Buscar</button>
            </form>
                <h2>{{ $juego->nombre }}</h2>
                <p>{{ $juego->descripcion }}</p>
                {{-- <a href="{{ route('menu.index') }}">Volver al menú</a> --}}
            </div>
        </main>
    </div>
</div>
@endsection
