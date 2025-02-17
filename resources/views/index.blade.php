@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Menú lateral -->
        <nav class="col-12 col-md-3 col-lg-2 sidebar" id="sidebar">
            <button class="btn btn-primary d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu">
                <i class="bi bi-list"></i> Menú
            </button>
            <div class="collapse d-md-block" id="sidebarMenu">
                <ul class="nav flex-column">
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
            <!-- Barra de búsqueda en la parte superior -->
            <nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
                <div class="container-fluid">
                    <form id="busquedaForm" class="d-flex ms-auto">
                        <select id="categoriaSelect" name="categoria" class="form-select me-2">
                            <option value="all">Todas</option>
                            <option value="juegos">Juegos</option>
                            <option value="materias">Materias</option>
                            <option value="proyectos">Proyectos</option>
                        </select>
                        <input type="text" id="nombreInput" name="nombre" placeholder="Buscar..." class="form-control me-2">
                        <button type="submit" class="btn btn-primary">Buscar</button>
                    </form>
                </div>
            </nav>

            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" id="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                </ol>
            </nav>

            <div class="container">
                <h2>Bienvenido, {{ Auth::user()->name }}</h2>

                <div id="resultadosBusqueda" class="row"> </div>
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

    .card {
        border: 1px solid #eee;
        margin-bottom: 20px;
    }

    .card-title a {
        color: #333;
        text-decoration: none;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById('busquedaForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const nombre = document.getElementById('nombreInput').value;
            const categoria = document.getElementById('categoriaSelect').value;

            fetch(`/buscar?nombre=${encodeURIComponent(nombre)}&categoria=${encodeURIComponent(categoria)}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Resultados:', data.resultados);

                    const resultadosDiv = document.getElementById('resultadosBusqueda');
                    resultadosDiv.innerHTML = ''; // Limpia resultados anteriores

                    if (data.resultados && data.resultados.length > 0) {
                        data.resultados.forEach(resultado => {
                            const card = document.createElement('div');
                            card.classList.add('col-md-4', 'card'); // Añade clases para el diseño de tarjeta

                            let link = "";
                            if (resultado.modelo === "App\Models\Juego") {
                                link = `/juego/${resultado.resultado.id}/descripcion`;
                            } else if (resultado.modelo === "App\Models\Materia") {
                                link = `/materia/${resultado.resultado.id}/descripcion`;
                            } else if (resultado.modelo === "App\Models\Proyecto") {
                                link = `/proyecto/${resultado.resultado.id}/descripcion`;
                            }

                            card.innerHTML = `
                                <div class="card-body">
                                    <h5 class="card-title"><a href="${link}">${resultado.resultado.nombre}</a></h5>
                                    <p class="card-text">${resultado.fragmento_descripcion}</p>
                                </div>
                            `;

                            resultadosDiv.appendChild(card);
                        });
                    } else {
                        resultadosDiv.innerHTML = '<p>No se encontraron resultados.</p>';
                    }

                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('resultadosBusqueda').innerHTML = `<p>Error en la búsqueda: ${error.message}</p>`;
                });
        });
    });
</script>
@endsection
