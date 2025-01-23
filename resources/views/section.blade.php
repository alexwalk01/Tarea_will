@extends('index')

@section('content')
    <h2>{{ ucfirst($section) }} de {{ $person }}</h2>
    <p>Aquí se muestra la información relacionada con la sección seleccionada.</p>
@endsection
