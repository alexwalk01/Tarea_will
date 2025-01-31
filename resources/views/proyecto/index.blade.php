@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Contenido principal -->
        <main class="col-12 col-md-9 col-lg-10 content">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" id="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('menu.index') }}">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Materias</li>
                </ol>
            </nav>

            <div class="container">
                <h2>Materias disponibles</h2>
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
