@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('layouts._sidebar') <!-- Se incluye el menú aquí -->

        <main class="col-12 col-md-9 col-lg-10 content">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('menu.index') }}">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Proyectos</li>
                </ol>
            </nav>

            <div class="container">
                <h2>Proyectos disponibles</h2>
                @if ($proyectos->isEmpty())
                    <p>No tienes proyectos disponibles.</p>
                @else
                    <ul>
                        @foreach ($proyectos as $proyecto)
                            <li>
                                <a href="{{ route('proyecto.show', $proyecto->id) }}">
                                    {{ $proyecto->nombre }}
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
