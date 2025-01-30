<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú</title>
</head>
<body>
    <h1>Menú</h1>


    <h2>Juegos</h2>
    @if (isset($juegos) && !$juegos->isEmpty())
        <ul>
            @foreach ($juegos as $juego)
                <li>
                    <a href="{{ route('juegos.index') }}">{{ $juego->nombre }}</a>
                </li>
            @endforeach
        </ul>
    @else
        <p>No hay juegos disponibles.</p>
    @endif

    <a href="{{ route('logout') }}"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
       Cerrar sesión
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</body>
</html>
