
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
<nav class="col-12 col-md-3 col-lg-2 sidebar" id="sidebar">
    <button class="btn btn-primary d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu">
        <i class="bi bi-list"></i> Menú
    </button>
    <div class="collapse d-md-block" id="sidebarMenu">
        <ul class="nav flex-column">


            <!-- Juegos -->
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#collapseJuegos" role="button">
                    <span><i class="bi bi-controller"></i> Juegos</span>
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
    /* Efecto para los íconos del menú */
.toggle-icon {
    transition: transform 0.3s ease-in-out;
}
.rotate {
    transform: rotate(180deg);
}

/* Efecto hover en los enlaces del menú */
.nav-link {
    position: relative;
    color: #333;
    transition: background-color 0.3s ease, color 0.3s ease;
}
.nav-link:hover {
    background-color: #007bff;
    color: white;
    border-radius: 5px;
    transform: scale(1.05);
}

/* Efecto "iluminación" al pasar el mouse */
.nav-link::before {
    content: "";
    position: absolute;
    left: 0;
    top: 50%;
    width: 4px;
    height: 0;
    background-color: #007bff;
    transition: height 0.3s ease, top 0.3s ease;
}
.nav-link:hover::before {
    height: 100%;
    top: 0;
}

/* Animación de despliegue más fluida */
.collapse {
    transition: height 0.3s ease-in-out;
}
.bi {
    font-size: 1.2rem; /* Ajusta el tamaño */
    margin-right: 8px; /* Espacio entre el icono y el texto */
}

</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const menuStateKey = "menuState"; // Clave para localStorage
        let menuState = JSON.parse(localStorage.getItem(menuStateKey)) || {}; // Obtener estado previo

        // Recorremos todas las secciones colapsables del menú
        document.querySelectorAll('.nav-link[data-bs-toggle="collapse"]').forEach(link => {
            let targetId = link.getAttribute("href").substring(1);
            let collapseElement = document.getElementById(targetId);
            let icon = link.querySelector(".toggle-icon");

            // **Antes de que Bootstrap actúe**, forzamos el estado guardado
            if (menuState[targetId]) {
                collapseElement.classList.add("show");
                icon.classList.add("rotate");
            }

            // Cuando se abre, lo guardamos en localStorage
            collapseElement.addEventListener("show.bs.collapse", function () {
                menuState[targetId] = true;
                localStorage.setItem(menuStateKey, JSON.stringify(menuState));
                icon.classList.add("rotate");
            });

            // Cuando se cierra, actualizamos el estado en localStorage
            collapseElement.addEventListener("hide.bs.collapse", function () {
                menuState[targetId] = false;
                localStorage.setItem(menuStateKey, JSON.stringify(menuState));
                icon.classList.remove("rotate");
            });
        });

        // Evitar que el menú colapsable se cierre al hacer clic en los enlaces internos
        document.querySelectorAll("#sidebarMenu .collapse .nav-link").forEach(link => {
            link.addEventListener("click", function (event) {
                event.stopPropagation(); // Evita que el clic cierre el menú
            });
        });
    });
</script>


