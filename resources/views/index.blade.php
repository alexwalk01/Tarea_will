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
                    <!-- Cerrar sesión -->
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="#" onclick="logout()">
                            <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                        </a>
                    </li>

                    <!-- Menú desplegable para Juegos -->
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#collapseJuegos" role="button" aria-expanded="false" aria-controls="collapseJuegos">
                            <i class="bi bi-gamepad"></i> Juegos <i class="bi bi-chevron-down float-end"></i>
                        </a>
                        <div class="collapse" id="collapseJuegos">
                            <ul class="nav flex-column ms-3">
                                @foreach ($juegos as $juego)
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('juego.descripcion', ['id' => $juego->id]) }}">{{ $juego->nombre }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>

                    <!-- Menú desplegable para Materias -->
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#collapseMaterias" role="button" aria-expanded="false" aria-controls="collapseMaterias">
                            <i class="bi bi-book"></i> Materias <i class="bi bi-chevron-down float-end"></i>
                        </a>
                        <div class="collapse" id="collapseMaterias">
                            <ul class="nav flex-column ms-3">
                                @foreach ($materias as $materia)
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('materia.descripcion', ['id' => $materia->id]) }}">{{ $materia->nombre }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>

                    <!-- Menú desplegable para Proyectos -->
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#collapseProyectos" role="button" aria-expanded="false" aria-controls="collapseProyectos">
                            <i class="bi bi-briefcase"></i> Proyectos <i class="bi bi-chevron-down float-end"></i>
                        </a>
                        <div class="collapse" id="collapseProyectos">
                            <ul class="nav flex-column ms-3">
                                @foreach ($proyectos as $proyecto)
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('proyecto.descripcion', ['id' => $proyecto->id]) }}">{{ $proyecto->nombre }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Contenido principal -->
        <main class="col-12 col-md-9 col-lg-10 content">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" id="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                </ol>
            </nav>

            <div class="container">
                <h2>Bienvenido, {{ Auth::user()->name }}</h2>

                <!-- Sección de Juegos -->
                <h3>Juegos</h3>
                @if ($juegos->isEmpty())
                    <p>No tienes juegos disponibles.</p>
                @else
                    <ul>
                        @foreach ($juegos as $juego)
                            <li>{{ $juego->nombre }}</li>
                        @endforeach
                    </ul>
                @endif

                <!-- Sección de Materias -->
                <h3>Materias</h3>
                @if ($materias->isEmpty())
                    <p>No tienes materias disponibles.</p>
                @else
                    <ul>
                        @foreach ($materias as $materia)
                            <li>{{ $materia->nombre }}</li>
                        @endforeach
                    </ul>
                @endif

                <!-- Sección de Proyectos -->
                <h3>Proyectos</h3>
                @if ($proyectos->isEmpty())
                    <p>No tienes proyectos disponibles.</p>
                @else
                    <ul>
                        @foreach ($proyectos as $proyecto)
                            <li>{{ $proyecto->nombre }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </main>
    </div>
</div>

<script>
    // Función para cerrar sesión
    function logout() {
        fetch('{{ route("logout") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            credentials: 'same-origin'
        })
        .then(response => {
            if (response.ok) {
                window.location.href = '/login';
            }
            else {
                alert('Error al cerrar sesión');
            }
        })
        .catch(error => {
            alert('Error al realizar la solicitud');
        });
    }
</script>

@endsection
