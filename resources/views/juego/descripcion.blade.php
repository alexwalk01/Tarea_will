<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Descripción del Juego</title>
</head>
<body>
    <h1>{{ $juego->nombre }}</h1>
    <p>{{ $juego->descripcion }}</p>
    <a href="{{ route('menu.index') }}">Volver al menú</a>
</body>
</html>
