@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('layouts._sidebar') <!-- Se incluye el menú aquí -->

        <main class="col-12 col-md-9 col-lg-10 content">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('menu.index') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('proyecto.index') }}">Proyectos</a></li>
                    <li class="breadcrumb-item active">{{ $proyecto->nombre }}</li>
                </ol>
            </nav>

            <div class="container">
                <h2>{{ $proyecto->nombre }}</h2>
                <p><strong>Descripción:</strong> {{ $proyecto->descripcion }}</p>
            </div>
        </main>
    </div>
</div>
@endsection
