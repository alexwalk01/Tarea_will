@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar de navegación -->
        <nav class="col-12 col-md-3 col-lg-2 sidebar" id="sidebar">
            <button class="btn btn-primary d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu">
                <i class="bi bi-list"></i> Menú
            </button>
            <div class="collapse d-md-block" id="sidebarMenu">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="#" onclick="logout()">
                            <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('juego.index') }}">
                            <i class="bi bi-gamepad"></i> Juegos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('materia.index') }}">
                            <i class="bi bi-book"></i> Materias
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('proyecto.index') }}">
                            <i class="bi bi-briefcase"></i> Proyectos
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Contenido principal -->
        <main class="col-12 col-md-9 col-lg-10 content">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" id="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('menu.index') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('proyecto.index') }}">Proyectos</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $proyecto->nombre }}</li>
                </ol>
            </nav>

            <div class="container">
                <h2>{{ $proyecto->nombre }}</h2>
                <p><strong>Descripción:</strong> {{ $proyecto->descripcion }}</p>
                <
            </div>
        </main>
    </div>
</div>

<script>
    // Función para cerrar sesión
    function logout() {
        fetch('/logout', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
            credentials: 'same-origin'
        })
        .then(response => {
            if (response.ok) { window.location.href = '/login'; }
            else { alert('Error al cerrar sesión'); }
        })
        .catch(error => { alert('Error al realizar la solicitud'); });
    }
</script>

@endsection
