@extends('layouts.app')

@section('content')
    <h2>Resultados de búsqueda para: "{{ $query }}" en "{{ ucfirst($categoria) }}"</h2>

    @if($resultados->isEmpty())
        <p>No se encontraron resultados en la categoría "{{ ucfirst($categoria) }}".</p>

        <!-- Botón para regresar al inicio -->
        <button onclick="window.location.href='{{ url('/') }}'" 
                style="padding: 10px 20px; background-color: red; color: white; border: none; border-radius: 5px; cursor: pointer; margin-top: 20px;">
            Volver al inicio
        </button>

    @else
        <ul>
            @foreach($resultados as $resultado)
                <li>
                    <!-- Verificamos la categoría y generamos el enlace correspondiente -->
                    @if($categoria == 'juegos')
                        <a href="{{ route('juegos.show', $resultado->id) }}">{{ $resultado->nombre }}</a>
                    @elseif($categoria == 'materias')
                        <a href="{{ route('materias.show', $resultado->id) }}">{{ $resultado->nombre }}</a>
                    @elseif($categoria == 'proyectos')
                        <a href="{{ route('proyectos.show', $resultado->id) }}">{{ $resultado->nombre }}</a>
                    @endif
                </li>
            @endforeach
        </ul>
    @endif
@endsection
