@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('layouts._sidebar') <!-- Se incluye el menú -->

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
                <div>
                <div class="carousel-wrapper">
  <div id="carouselExample" class="carousel slide carousel-container" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <a href="{{ route('materia.index') }}">
          <img src="{{ asset('images/imagen1.jpg') }}" class="d-block w-100" alt="Imagen 1">
        </a>
      </div>
      <div class="carousel-item">
        <a href="{{ route('juego.index') }}">
          <img src="{{ asset('images/imagen2.jpg') }}" class="d-block w-100" alt="Imagen 2">
        </a>
      </div>
      <div class="carousel-item">
        <a href="{{ route('proyecto.index') }}">
          <img src="{{ asset('images/imagen3.jpg') }}" class="d-block w-100" alt="Imagen 3">
        </a>
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
                <div id="resultadosBusqueda" class="row mt-4"> </div>
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



  /* Contenedor que centra el carrusel en la pantalla */
  .carousel-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh; /* Asegura que el carrusel esté centrado verticalmente */
  }

  /* Tamaño reducido del carrusel */
  .carousel-container {
    max-width: 400px; /* Ancho del carrusel */
    max-height: 250px; /* Altura máxima */
    width: 100%;
  }

  /* Ajuste de imágenes dentro del carrusel */
  .carousel-inner img {
    max-height: 250px; /* Mantiene la altura máxima */
    object-fit: contain; /* Evita que la imagen se deforme o recorte */
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
