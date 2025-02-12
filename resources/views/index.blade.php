@extends('layouts.app')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

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
                <!-- Nuevo buscador general -->
                <form action="{{ route('buscar.general') }}" method="GET" style="position: fixed; top: 5%; right: 200px; z-index: 1000; display: flex; gap: 5px; align-items: center; transform: translateY(-50%); font-size: 12px;">
            <input required type="text" name="nombre" placeholder="Búsqueda general..." value="{{ request('nombre') }}" style="padding: 3px; font-size: 12px;">
            <button type="submit" style="padding: 3px 8px; font-size: 12px; cursor: pointer;">Buscar</button>
            </form>
                
                <form action="{{ route('buscar.general') }}" method="GET" style="position: fixed; top: 20%; right: 10px; z-index: 1000; display: flex; gap: 10px; align-items: center; transform: translateY(-50%);">
                    <select name="categoria" style="padding: 5px; font-size: 14px;">
                        <option value="juegos" {{ request('categoria') == 'juegos' ? 'selected' : '' }}>Juegos</option>
                        <option value="materias" {{ request('categoria') == 'materias' ? 'selected' : '' }}>Materias</option>
                        <option value="proyectos" {{ request('categoria') == 'proyectos' ? 'selected' : '' }}>Proyectos</option>
                    </select>
                    <input required type="text" name="nombre" placeholder="Buscar..." value="{{ request('nombre') }}" style="padding: 5px; font-size: 14px;">
                    <button type="submit" style="padding: 5px 10px; font-size: 14px; cursor: pointer;">Buscar</button>
                </form>




                    <!-- Menú desplegable para Juegos -->
                    <li class="nav-item">
                        <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#collapseJuegos" role="button" aria-expanded="false" aria-controls="collapseJuegos">
                            <i class="bi bi-gamepad"></i> Juegos <i class="bi bi-chevron-down float-end toggle-icon" id="iconJuegos"></i>
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
                        <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#collapseMaterias" role="button" aria-expanded="false" aria-controls="collapseMaterias">
                            <i class="bi bi-book"></i> Materias <i class="bi bi-chevron-down float-end toggle-icon" id="iconMaterias"></i>
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
                        <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#collapseProyectos" role="button" aria-expanded="false" aria-controls="collapseProyectos">
                            <i class="bi bi-briefcase"></i> Proyectos <i class="bi bi-chevron-down float-end toggle-icon" id="iconProyectos"></i>
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

<style>
    .toggle-icon {
        transition: transform 0.3s ease-in-out;
    }
    .rotate {
        transform: rotate(180deg);
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Función para alternar la rotación de la flecha
        function toggleIcon(collapseId, iconId) {
            let collapseElement = document.getElementById(collapseId);
            let iconElement = document.getElementById(iconId);

            // Asegúrate de aplicar el estado inicial (por si ya está expandido)
            if (collapseElement.classList.contains("show")) {
                iconElement.classList.add("rotate");
            }

            collapseElement.addEventListener("show.bs.collapse", function () {
                iconElement.classList.add("rotate");
            });

            collapseElement.addEventListener("hide.bs.collapse", function () {
                iconElement.classList.remove("rotate");
            });
        }

        // Aplicar la función a cada menú
        toggleIcon("collapseJuegos", "iconJuegos");
        toggleIcon("collapseMaterias", "iconMaterias");
        toggleIcon("collapseProyectos", "iconProyectos");
    });
</script>

@endsection
