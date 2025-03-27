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

                <!-- Formulario para habilitar/deshabilitar autenticación multifactor -->
                            <form action="{{ route('auth.toggleMFA') }}" method="POST">
                @csrf
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="mfaCheckbox" name="mfa_enabled"
                        {{ Auth::user()->mfa_enabled ? 'checked' : '' }}>
                    <label class="form-check-label" for="mfaCheckbox">Habilitar autenticación multifactor</label>
                </div>
                <button type="submit" class="btn btn-primary mt-2">Actualizar</button>
            </form>

            @if(session('status'))
                <p class="text-success">{{ session('status') }}</p>
            @endif


                <div id="elementos">
                    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img id="img1" src="{{ asset('images/imagen1.jpg') }}" class="d-block w-100" alt="Imagen 1" title="Juegos">
                                <p>Juegos</p>
                            </div>
                            <div class="carousel-item">
                                <img id="img2" src="{{ asset('images/imagen2.jpg') }}" class="d-block w-100" alt="Imagen 2" title="Materias">
                                <p>Materias</p>
                            </div>
                            <div class="carousel-item">
                                <img id="img3" src="{{ asset('images/imagen3.jpg') }}" class="d-block w-100" alt="Imagen 3" title="Proyectos">
                                <p>Proyectos</p>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
                <div id="resultadosBusqueda" class="row mt-4"></div>
            </div>
        </main>
    </div>
</div>

<style>
    .card {
        border: 1px solid #eee;
        margin-bottom: 20px;
        padding: 15px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    .card-title a {
        color: #333;
        text-decoration: none;
    }
</style>

<!-- Script de Búsqueda -->
<script>
    document.addEventListener("DOMContentLoaded", function () {

        // Asignar eventos a las imágenes del carrusel
        document.getElementById('img1').addEventListener('click', cargarJuegos);
        document.getElementById('img2').addEventListener('click', cargarMaterias);
        document.getElementById('img3').addEventListener('click', cargarProyectos);

        //traer todas los juegos
        function cargarJuegos() {
            fetch('/cargar-todos-los-juegos')
                .then(response => response.json())
                .then(data => mostrarTarjetas(data))
                .catch(error => console.error('Error cargando juegos:', error));
        }

        //traer todas las materias
        function cargarMaterias() {
            fetch('/cargar-todas-las-materias')
            .then(response => response.json())
            .then(data => mostrarTarjetas(data))
            .catch(error => console.error('Error cargando materias:', error));
        }

        //traer todos los proyectos
        function cargarProyectos() {
            fetch('/cargar-todos-los-proyectos')
                .then(response => response.json())
                .then(data => mostrarTarjetas(data))
                .catch(error => console.error('Error cargando proyectos:', error));
        }

        //Pintar las tarjetas con lo que trae el carrusel
        function mostrarTarjetas(datos) {
            const elementosDiv = document.getElementById('elementos');
            elementosDiv.innerHTML = ''; // Vaciar el contenedor

            if (!datos || datos.length === 0) {
                elementosDiv.innerHTML = `<p class="text-warning">No hay elementos disponibles.</p>`;
                return;
            }

            const rowDiv = document.createElement('div');
            rowDiv.classList.add('row');

            datos.forEach(item => {
                const colDiv = document.createElement('div');
                colDiv.classList.add('col-md-4', 'mb-3');

                let link = "";
                if (item.modelo === "App\\Models\\Juego") {
                    link = `/juego/${item.id}`;
                } else if (item.modelo === "App\\Models\\Materia") {
                    link = `/materia/${item.id}`;
                } else if (item.modelo === "App\\Models\\Proyecto") {
                    link = `/proyecto/${item.id}`;
                }

                colDiv.innerHTML = `
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><a href="${link}" class="text-decoration-none">${item.nombre}</a></h5>
                            <p class="card-text">${item.descripcion}</p>
                        </div>
                    </div>
                `;
                rowDiv.appendChild(colDiv);
            });

            elementosDiv.appendChild(rowDiv);
        }

        // Búsqueda
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

        // Recargar la página cada 30 segundos
        setInterval(function() {
            location.reload();
        }, 30000);
    });
</script>
@endsection
