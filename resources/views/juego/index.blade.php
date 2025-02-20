@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('layouts._sidebar') <!-- Se incluye el menú -->

        <main class="col-12 col-md-9 col-lg-10 content">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('menu.index') }}">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Juegos</li>
                </ol>
            </nav>

            <!-- Barra de búsqueda -->
            <nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
                <div class="container-fluid">
                <form id="busquedaForm" class="d-flex ms-auto" action="{{ route('buscar.general') }}" method="GET">
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
    <h2>Juegos disponibles</h2>
    <div id="contenedorJuegos" class="row">
        @foreach ($juegos->take(3) as $juego)
            <div class="col-md-4 mb-3 juego-item">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ route('juego.show', $juego->id) }}" class="text-decoration-none">{{ $juego->nombre }}</a>
                        </h5>
                        <p class="card-text">{{ $juego->descripcion ?? 'Sin descripción' }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div id="cargando" style="display: none; text-align: center; margin: 20px 0;">
        <p>Cargando más juegos...</p>
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

<script>
document.addEventListener("DOMContentLoaded", function () {
    let offset = 3; // Comienza después de los 3 primeros juegos
    let cargando = false; // Para evitar múltiples solicitudes simultáneas

    function cargarMasJuegos() {
        if (cargando) return;
        cargando = true;
        document.getElementById("cargando").style.display = "block";

        fetch(`/cargar-mas-juegos?offset=${offset}`)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    const contenedor = document.getElementById("contenedorJuegos");

                    data.forEach(juego => {
                        const card = document.createElement('div');
                        card.classList.add('col-md-4', 'mb-3', 'juego-item');
                        card.innerHTML = `
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="/juego/${juego.id}" class="text-decoration-none">${juego.nombre}</a>
                                    </h5>
                                    <p class="card-text">${juego.descripcion || 'Sin descripción'}</p>
                                </div>
                            </div>
                        `;
                        contenedor.appendChild(card);
                    });

                    offset += 3; // Aumenta el offset para la siguiente carga
                } else {
                    window.removeEventListener('scroll', handleScroll); // Si no hay más juegos, desactiva el evento
                }
                cargando = false;
                document.getElementById("cargando").style.display = "none";
            })
            .catch(error => console.error('Error al cargar más juegos:', error));
    }

    function handleScroll() {
        if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 200) {
            cargarMasJuegos();
        }
    }

    window.addEventListener('scroll', handleScroll);
});
</script>
@endsection