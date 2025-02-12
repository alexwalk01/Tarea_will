@extends('layouts.app')

@section('content')
    <h2>Resultados de búsqueda para: "{{ $query }}" en "{{ ucfirst($categoria) }}"</h2>

    @if(empty($resultados))
        <p>No se encontraron resultados en la categoría "{{ ucfirst($categoria) }}".</p>
        <div class="text-center mt-3">
            <a href="{{ url('/') }}" class="btn btn-primary">Volver al inicio</a>
        </div>
    @else
        <div class="row">
            @foreach($resultados as $resultado)
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">
                                @if($categoria == 'juegos')
                                    <a href="{{ route('juegos.show', $resultado['resultado']->id) }}">{{ $resultado['resultado']->nombre }}</a>
                                @elseif($categoria == 'materias')
                                    <a href="{{ route('materias.show', $resultado['resultado']->id) }}">{{ $resultado['resultado']->nombre }}</a>
                                @elseif($categoria == 'proyectos')
                                    <a href="{{ route('proyectos.show', $resultado['resultado']->id) }}">{{ $resultado['resultado']->nombre }}</a>
                                @endif
                            </h5>
                            <p class="card-text small">(Coincidencia en: {{ $resultado['coincidencia'] }})</p>
                            <p class="card-text fragmento">{{ $resultado['fragmento_descripcion'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center mt-3">
            <a href="{{ url('/') }}" class="btn btn-primary">Volver al inicio</a>
        </div>
    @endif

    <style>
        .card {
            border: 1px solid #eee;
            box-shadow: 2px 2px 5px rgba(0,0,0,0.1);
        }

        .card-title a {
            color: #333;
            text-decoration: none;
        }

        .fragmento {
            color: #777;
            font-size: 0.9em;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0069d9;
            border-color: #0062cc;
        }
    </style>
@endsection
