
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<nav class="col-12 col-md-3 col-lg-2 sidebar" id="sidebar">
    <button class="btn btn-primary d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu">
        <i class="bi bi-list"></i> Menú
    </button>
    <div class="collapse d-md-block" id="sidebarMenu">
        <ul class="nav flex-column">


            <!-- Juegos -->
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#collapseJuegos" role="button">
                    <span><i class="bi bi-gamepad"></i> Juegos</span>
                    <i class="bi bi-chevron-down float-end toggle-icon" id="iconJuegos"></i>
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

            <!-- Materias -->
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#collapseMaterias" role="button">
                    <span><i class="bi bi-book"></i> Materias</span>
                    <i class="bi bi-chevron-down float-end toggle-icon" id="iconMaterias"></i>
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

            <!-- Proyectos -->
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#collapseProyectos" role="button">
                    <span><i class="bi bi-briefcase"></i> Proyectos</span>
                    <i class="bi bi-chevron-down float-end toggle-icon" id="iconProyectos"></i>
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
