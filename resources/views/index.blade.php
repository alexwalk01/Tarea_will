<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Sitio</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        header {
            background-color: #007bff;
            color: white;
            padding: 15px;
            text-align: center;
        }
        .sidebar {
            background-color: #343a40;
            color: white;
            height: 100vh;
            padding-top: 20px;
        }
        .sidebar .nav-link {
            color: white;
        }
        .sidebar .nav-link:hover {
            background-color: #495057;
            border-radius: 5px;
        }
        .content {
            padding: 20px;
        }
        footer {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 10px 0;
        }
        .breadcrumb {
            background-color: transparent;
            padding: 0;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <h1>Mi Sitio</h1>
    </header>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 sidebar">
                <ul class="nav flex-column">
                    @foreach ($people as $person)
                        <li class="nav-item">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#submenu-{{ $loop->index }}" onclick="updateBreadcrumb('Inicio', '{{ $person }}')">
                                <i class="bi bi-person-circle"></i> {{ $person }}
                            </a>
                            <div class="collapse" id="submenu-{{ $loop->index }}">
                                <ul class="list-unstyled ms-3">
                                    <!-- Materias -->
                                    <li>
                                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#materias-{{ $loop->index }}" onclick="updateBreadcrumb('Inicio', '{{ $person }}', 'Materias')">
                                            <i class="bi bi-book"></i> Materias
                                        </a>
                                        <div class="collapse" id="materias-{{ $loop->index }}">
                                            <ul class="list-unstyled ms-3">
                                                <li><a class="nav-link" href="#" onclick="updateBreadcrumb('Inicio', '{{ $person }}', 'Materias', 'Base de Datos')"><i class="bi bi-file-earmark-text"></i> Base de Datos</a></li>
                                                <li><a class="nav-link" href="#" onclick="updateBreadcrumb('Inicio', '{{ $person }}', 'Materias', 'Aplicación Móvil')"><i class="bi bi-file-earmark-text"></i> Aplicación Móvil</a></li>
                                                <li><a class="nav-link" href="#" onclick="updateBreadcrumb('Inicio', '{{ $person }}', 'Materias', 'Desarrollo Web')"><i class="bi bi-file-earmark-text"></i> Desarrollo Web</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <!-- Juegos -->
                                    <li>
                                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#juegos-{{ $loop->index }}" onclick="updateBreadcrumb('Inicio', '{{ $person }}', 'Juegos')">
                                            <i class="bi bi-controller"></i> Juegos
                                        </a>
                                        <div class="collapse" id="juegos-{{ $loop->index }}">
                                            <ul class="list-unstyled ms-3">
                                                <li><a class="nav-link" href="#" onclick="updateBreadcrumb('Inicio', '{{ $person }}', 'Juegos', 'Ajedrez')"><i class="bi bi-controller"></i> Ajedrez</a></li>
                                                <li><a class="nav-link" href="#" onclick="updateBreadcrumb('Inicio', '{{ $person }}', 'Juegos', 'Futbol')"><i class="bi bi-controller"></i> Futbol</a></li>
                                                <li><a class="nav-link" href="#" onclick="updateBreadcrumb('Inicio', '{{ $person }}', 'Juegos', 'Cubo de rubik')"><i class="bi bi-controller"></i> Cubo de rubik</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <!-- Proyectos -->
                                    <li>
                                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#proyectos-{{ $loop->index }}" onclick="updateBreadcrumb('Inicio', '{{ $person }}', 'Proyectos')">
                                            <i class="bi bi-briefcase"></i> Proyectos
                                        </a>
                                        <div class="collapse" id="proyectos-{{ $loop->index }}">
                                            <ul class="list-unstyled ms-3">
                                                <li><a class="nav-link" href="#" onclick="updateBreadcrumb('Inicio', '{{ $person }}', 'Proyectos', 'Taxis locales')"><i class="bi bi-briefcase"></i> Taxis locales</a></li>
                                                <li><a class="nav-link" href="#" onclick="updateBreadcrumb('Inicio', '{{ $person }}', 'Proyectos', 'Psicologia')"><i class="bi bi-briefcase"></i> Psicologia</a></li>
                                                <li><a class="nav-link" href="#" onclick="updateBreadcrumb('Inicio', '{{ $person }}', 'Proyectos', 'Escolar')"><i class="bi bi-briefcase"></i> Escolar</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 col-lg-10 content">
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb" id="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    </ol>
                </nav>
                
                <!-- Section Content -->
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Mi Sitio. Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Función para actualizar el breadcrumb
        function updateBreadcrumb(...sections) {
            const breadcrumbContainer = document.getElementById('breadcrumb');
            breadcrumbContainer.innerHTML = ''; // Limpiar el breadcrumb antes de agregar nuevas secciones

            // Agregar los elementos del breadcrumb
            sections.forEach((section, index) => {
                const listItem = document.createElement('li');
                listItem.classList.add('breadcrumb-item');
                if (index === sections.length - 1) {
                    listItem.classList.add('active');
                    listItem.setAttribute('aria-current', 'page');
                    listItem.textContent = section;
                } else {
                    const link = document.createElement('a');
                    link.href = "#";
                    link.textContent = section;
                    listItem.appendChild(link);
                }
                breadcrumbContainer.appendChild(listItem);
            });
        }
    </script>
</body>
</html>
