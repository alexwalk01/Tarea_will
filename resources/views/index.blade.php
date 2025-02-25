@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('layouts._sidebar') 

        <main class="col-12 col-md-9 col-lg-10 content">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('menu.index') }}">Inicio</a></li>
                </ol>
            </nav>

            <!-- Barra de búsqueda -->
            <nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
                <div class="container-fluid">
                    <form id="busquedaForm" class="d-flex ms-auto">
                        <select id="categoriaSelect" name="categoria" class="form-select me-2">
                            <option value="all">Todas</option>
                            <option value="juegos">Juegos</option>
                            <option value="materias">Materias</option>
                            <option value="proyectos">Proyectos</option>
                        </select>
                        <input required type="text" id="nombreInput" name="nombre" placeholder="Buscar..." class="form-control me-2">
                        <button type="submit" class="btn btn-primary">Buscar</button>
                    </form>
                </div>
            </nav>
            <div class="container">
                <h2>Bienvenid@, {{ Auth::user()->name }}</h2>  
                <div id="resultadosBusqueda" class="row mt-4"></div>
                <!-- Carrusel -->
            <div class="carousel-wrapper">
                    <div id="carouselExample" class="carousel slide carousel-container" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="carousel-content">
                                    <a href="{{ route('materia.index') }}" class="overlay">
                                    <img src="{{ asset('images/imagen1.jpg') }}" class="d-block w-100" alt="Imagen 1">
                                    </a>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="carousel-content">
                                    <a href="{{ route('juego.index') }}" class="overlay">
                                    <img src="{{ asset('images/imagen2.jpg') }}" class="d-block w-100" alt="Imagen 2">
                                    </a>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="carousel-content">
                                    <a href="{{ route('proyecto.index') }}" class="overlay">
                                    <img src="{{ asset('images/imagen3.jpg') }}" class="d-block w-100" alt="Imagen 3">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
            
        </main>
    </div>
</div>

<style>
    /* Contenedor del carrusel */
    .carousel-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .carousel-container {
        max-width: 400px;
        max-height: 250px;
        width: 100%;
        position: relative;
    }

    .carousel-inner img {
        max-height: 250px;
        object-fit: cover;
        width: 100%;
    }

    /* Contenedor para el overlay */
    .carousel-content {
        position: relative;
        display: inline-block;
        width: 100%;
    }

    /* Estilos del overlay */
    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        color: white;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 20px;
        font-weight: bold;
        text-decoration: none;
        opacity: 0;
        transition: opacity 0.3s ease-in-out;
        z-index: 10;
    }

    /* Mostrar el overlay al pasar el mouse */
    .carousel-content:hover .overlay {
        opacity: 1;
    }
</style>

<!-- Script de Búsqueda -->
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
                    resultadosDiv.innerHTML = ''; // Limpiar resultados anteriores

                    if (data.resultados && data.resultados.length > 0) {
                        data.resultados.forEach(resultado => {
                            const card = document.createElement('div');
                            card.classList.add('col-md-4', 'mb-3');

                            let link = "";
                            if (resultado.modelo === "App\\Models\\Juego") {
                                link = `/juego/${resultado.resultado.id}`;
                            } else if (resultado.modelo === "App\\Models\\Materia") {
                                link = `/materia/${resultado.resultado.id}`;
                            } else if (resultado.modelo === "App\\Models\\Proyecto") {
                                link = `/proyecto/${resultado.resultado.id}`;
                            }

                            card.innerHTML = `
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title"><a href="${link}" class="text-decoration-none">${resultado.resultado.nombre}</a></h5>
                                        <p class="card-text">${resultado.fragmento_descripcion}</p>
                                    </div>
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
