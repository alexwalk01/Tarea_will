@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Descripción del Juego</title>
</head>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb" id="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('menu.index') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('juego.index') }}">Juegos</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $juego->nombre }}</li>
    </ol>
</nav>
<body>
    <h1>{{ $juego->nombre }}</h1>
    <p>{{ $juego->descripcion }}</p>
    <a href="{{ route('menu.index') }}">Volver al menú</a>
</body>
</html>
@endsection

@endsection
