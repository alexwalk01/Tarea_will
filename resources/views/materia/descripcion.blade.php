@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('layouts._sidebar')

        <main class="col-12 col-md-9 col-lg-10 content">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('menu.index') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('materia.index') }}">Materias</a></li>
                    <li class="breadcrumb-item active">{{ $materia->nombre }}</li>
                </ol>
            </nav>

            <div class="container">
                <h2>{{ $materia->nombre }}</h2>
                <p>{{ $materia->descripcion }}</p>
            </div>
        </main>
    </div>
</div>
@endsection
