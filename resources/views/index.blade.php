<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mi Sitio</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: white;
            margin-top: 4px; /* Para evitar que el contenido se solape con el encabezado */
        }

        .sidebar {
            background-color:rgb(251, 251, 251);
            color: black;
            padding-top: 10px;
        }

        .sidebar .nav-link {
            color: black;
        }

        .sidebar .nav-link:hover {
            background-color:rgb(67, 81, 95);
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
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .breadcrumb {
            background-color: transparent;
            padding: 0;
        }

        @media (max-width: 991px) {
            .content {
                margin-left: 0 !important;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-12 col-md-3 col-lg-2 sidebar" id="sidebar">
                <button class="btn btn-primary d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-expanded="false" aria-controls="sidebarMenu">
                    <i class="bi bi-list"></i> Menú
                </button>
                <div class="collapse d-md-block" id="sidebarMenu">
                    <ul class="nav flex-column">
                        @foreach (['Alex', 'Mariana', 'Froy', 'Hugo'] as $index => $person)
                            <li class="nav-item">
                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#submenu-{{ $index }}" onclick="updateBreadcrumb('Inicio', '{{ $person }}')">
                                    <i class="bi bi-person-circle"></i> {{ $person }}
                                </a>
                                <div class="collapse" id="submenu-{{ $index }}">
                                    <ul class="list-unstyled ms-3">
                                        <li>
                                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#materias-{{ $index }}" onclick="updateBreadcrumb('Inicio', '{{ $person }}', 'Materias')">
                                                <i class="bi bi-book"></i> Materias
                                            </a>
                                            <div class="collapse" id="materias-{{ $index }}">
                                                <ul class="list-unstyled ms-3">
                                                    <li><a class="nav-link" href="#" onclick="updateBreadcrumb('Inicio', '{{ $person }}', 'Materias', 'Base de Datos')"><i class="bi bi-file-earmark-text"></i> Base de Datos</a></li>
                                                    <li><a class="nav-link" href="#" onclick="updateBreadcrumb('Inicio', '{{ $person }}', 'Materias', 'Aplicación Móvil')"><i class="bi bi-file-earmark-text"></i> Aplicación Móvil</a></li>
                                                    <li><a class="nav-link" href="#" onclick="updateBreadcrumb('Inicio', '{{ $person }}', 'Materias', 'Desarrollo Web')"><i class="bi bi-file-earmark-text"></i> Desarrollo Web</a></li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li>
                                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#juegos-{{ $index }}" onclick="updateBreadcrumb('Inicio', '{{ $person }}', 'Juegos')">
                                                <i class="bi bi-controller"></i> Juegos
                                            </a>
                                            <div class="collapse" id="juegos-{{ $index }}">
                                                <ul class="list-unstyled ms-3">
                                                    <li><a class="nav-link" href="#" onclick="updateBreadcrumb('Inicio', '{{ $person }}', 'Juegos', 'Ajedrez')"><i class="bi bi-controller"></i> Ajedrez</a></li>
                                                    <li><a class="nav-link" href="#" onclick="updateBreadcrumb('Inicio', '{{ $person }}', 'Juegos', 'Futbol')"><i class="bi bi-controller"></i> Futbol</a></li>
                                                    <li><a class="nav-link" href="#" onclick="updateBreadcrumb('Inicio', '{{ $person }}', 'Juegos', 'Cubo de Rubik')"><i class="bi bi-controller"></i> Cubo de Rubik</a></li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li>
                                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#proyectos-{{ $index }}" onclick="updateBreadcrumb('Inicio', '{{ $person }}', 'Proyectos')">
                                                <i class="bi bi-briefcase"></i> Proyectos
                                            </a>
                                            <div class="collapse" id="proyectos-{{ $index }}">
                                                <ul class="list-unstyled ms-3">
                                                    <li><a class="nav-link" href="#" onclick="updateBreadcrumb('Inicio', '{{ $person }}', 'Proyectos', 'Taxis Locales')"><i class="bi bi-briefcase"></i> Taxis Locales</a></li>
                                                    <li><a class="nav-link" href="#" onclick="updateBreadcrumb('Inicio', '{{ $person }}', 'Proyectos', 'Psicología')"><i class="bi bi-briefcase"></i> Psicología</a></li>
                                                    <li><a class="nav-link" href="#" onclick="updateBreadcrumb('Inicio', '{{ $person }}', 'Proyectos', 'Escolar')"><i class="bi bi-briefcase"></i> Escolar</a></li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        @endforeach

                        <!-- Cerrar sesión -->
                        <li class="nav-item">
                            <a class="nav-link text-danger" href="#" onclick="logout()">
                                <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Contenido Principal -->
            <main class="col-12 col-md-9 col-lg-10 content">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb" id="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    </ol>
                </nav>

                <div>
                    <h2>Bienvenido Admin</h2>
                    <p>Selecciona una opción del menú para explorar el contenido.</p>
                </div>
            </main>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Mi Sitio. Todos los derechos reservados.</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Breadcrumb Script -->
    <script>
        function updateBreadcrumb(...sections) {
            const breadcrumbContainer = document.getElementById('breadcrumb');
            breadcrumbContainer.innerHTML = '';

            sections.forEach((section, index) => {
                const li = document.createElement('li');
                li.classList.add('breadcrumb-item');
                if (index === sections.length - 1) {
                    li.classList.add('active');
                    li.setAttribute('aria-current', 'page');
                    li.textContent = section;
                } else {
                    const link = document.createElement('a');
                    link.href = "#";
                    link.textContent = section;
                    li.appendChild(link);
                }
                breadcrumbContainer.appendChild(li);
            });
        }

        function logout() {
            fetch('/logout', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                credentials: 'same-origin'
            })
            .then(response => {
                if (response.ok) {
                    window.location.href = '/login';
                } else {
                    alert('Error al cerrar sesión');
                }
            })
            .catch(error => {
                alert('Error al realizar la solicitud');
            });
        }
    </script>
</body>
</html>
