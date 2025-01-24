<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desarrollo web</title>
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
                                            <li><a class="nav-link" href="#" onclick="updateBreadcrumb('Inicio', '{{ $person }}', 'Materias', 'Base de Datos'); updateSectionContent('Materias', 'Base de Datos')"><i class="bi bi-file-earmark-text"></i> Base de Datos</a></li>
                                            <li><a class="nav-link" href="#" onclick="updateBreadcrumb('Inicio', '{{ $person }}', 'Materias', 'Aplicación Móvil'); updateSectionContent('Materias', 'Aplicación Móvil')"><i class="bi bi-file-earmark-text"></i> Aplicación Móvil</a></li>
                                            <li><a class="nav-link" href="#" onclick="updateBreadcrumb('Inicio', '{{ $person }}', 'Materias', 'Desarrollo Web'); updateSectionContent('Materias', 'Desarrollo Web')"><i class="bi bi-file-earmark-text"></i> Desarrollo Web</a></li>
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
                                            <li><a class="nav-link" href="#" onclick="updateBreadcrumb('Inicio', '{{ $person }}', 'Juegos', 'Ajedrez'); updateSectionContent('Juegos', 'Ajedrez')"><i class="bi bi-controller"></i> Ajedrez</a></li>
                                            <li><a class="nav-link" href="#" onclick="updateBreadcrumb('Inicio', '{{ $person }}', 'Juegos', 'Futbol'); updateSectionContent('Juegos', 'Futbol')"><i class="bi bi-controller"></i> Futbol</a></li>
                                            <li><a class="nav-link" href="#" onclick="updateBreadcrumb('Inicio', '{{ $person }}', 'Juegos', 'Cubo de rubik'); updateSectionContent('Juegos', 'Cubo de rubik')"><i class="bi bi-controller"></i> Cubo de Rubik</a></li>
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
                                            <li><a class="nav-link" href="#" onclick="updateBreadcrumb('Inicio', '{{ $person }}', 'Proyectos', 'Taxis locales'); updateSectionContent('Proyectos', 'Taxis locales')"><i class="bi bi-briefcase"></i> Taxis locales</a></li>
                                            <li><a class="nav-link" href="#" onclick="updateBreadcrumb('Inicio', '{{ $person }}', 'Proyectos', 'Psicologia'); updateSectionContent('Proyectos', 'Psicologia')"><i class="bi bi-briefcase"></i> Psicologia</a></li>
                                            <li><a class="nav-link" href="#" onclick="updateBreadcrumb('Inicio', '{{ $person }}', 'Proyectos', 'Escolar'); updateSectionContent('Proyectos', 'Escolar')"><i class="bi bi-briefcase"></i> Escolar</a></li>
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
                <div id="section-content">
        <h3>Selecciona una opción para ver más detalles.</h3>
    </div>
                @yield('content')
            </main>
        </div>
    </div>

    <script>
    function updateBreadcrumb(...path) {
    // Actualizar el breadcrumb
    const breadcrumbContainer = document.getElementById('breadcrumb-container');
    breadcrumbContainer.innerHTML = '';  // Limpiar los breadcrumbs existentes

    path.forEach((part, index) => {
        const breadcrumbItem = document.createElement('li');
        breadcrumbItem.classList.add('breadcrumb-item');

        if (index === path.length - 1) {
            // Si es el último breadcrumb, no es clickeable
            breadcrumbItem.classList.add('active');
            breadcrumbItem.textContent = part;
        } else {
            const breadcrumbLink = document.createElement('a');
            breadcrumbLink.href = '#';
            breadcrumbLink.textContent = part;
            breadcrumbLink.onclick = () => updateBreadcrumb(...path.slice(0, index + 1));
            breadcrumbItem.appendChild(breadcrumbLink);
        }

        breadcrumbContainer.appendChild(breadcrumbItem);
    });
}


    // Función para actualizar el contenido de la sección principal
    function updateSectionContent(category, topic) {
        const sectionContent = document.getElementById('section-content');
        
        let description = '';
        let imageUrl = '';

        // Definir la descripción y la imagen según la categoría y el tema
        if (category === 'Materias') {
            if (topic === 'Base de Datos') {
                description = 'Descripción sobre la materia de Base de Datos.';
                imageUrl = 'ruta_a_imagen_base_de_datos.jpg';  // Aquí debes colocar la ruta de la imagen
            } else if (topic === 'Aplicación Móvil') {
                description = 'Descripción sobre la materia de Aplicación Móvil.';
                imageUrl = 'ruta_a_imagen_aplicacion_movil.jpg';  // Aquí debes colocar la ruta de la imagen
            } else if (topic === 'Desarrollo Web') {
                description = 'Descripción sobre la materia de Desarrollo Web.';
                imageUrl = 'ruta_a_imagen_desarrollo_web.jpg';  // Aquí debes colocar la ruta de la imagen
            }
        } else if (category === 'Juegos') {
            if (topic === 'Ajedrez') {
                description = 'Descripción sobre el juego de Ajedrez.';
                imageUrl = 'ruta_a_imagen_ajedrez.jpg';
            } else if (topic === 'Futbol') {
                description = 'Descripción sobre el juego de Futbol.';
                imageUrl = 'ruta_a_imagen_futbol.jpg';
            } else if (topic === 'Cubo de rubik') {
                description = 'Descripción sobre el juego Cubo de Rubik.';
                imageUrl = 'ruta_a_imagen_cubo_rubik.jpg';
            }
        } else if (category === 'Proyectos') {
            if (topic === 'Taxis locales') {
                description = 'Descripción sobre el proyecto de Taxis locales.';
                imageUrl = 'ruta_a_imagen_taxis_locales.jpg';
            } else if (topic === 'Psicologia') {
                description = 'Descripción sobre el proyecto de Psicología.';
                imageUrl = 'ruta_a_imagen_psicologia.jpg';
            } else if (topic === 'Escolar') {
                description = 'Descripción sobre el proyecto Escolar.';
                imageUrl = 'ruta_a_imagen_escolar.jpg';
            }
        }

        // Mostrar la descripción y la imagen en el contenido
        sectionContent.innerHTML = `
            <h3>${topic}</h3>
            <p>${description}</p>
            <img src="${imageUrl}" alt="${topic}" class="img-fluid">
        `;
    }
</script>

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
