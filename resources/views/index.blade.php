<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Menú</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body { font-family: Arial, sans-serif; background-color: white; margin-top: 4px; }
        .sidebar { background-color: #f8f9fa; color: black; padding-top: 10px; }
        .sidebar .nav-link { color: black; }
        .sidebar .nav-link:hover { background-color: #495057; border-radius: 5px; }
        .content { padding: 20px; }
        footer { background-color: #343a40; color: white; text-align: center; padding: 10px 0; width: 100%; position: fixed; bottom: 0; }
        .breadcrumb { background-color: transparent; padding: 0; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-12 col-md-3 col-lg-2 sidebar" id="sidebar">
                <button class="btn btn-primary d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu">
                    <i class="bi bi-list"></i> Menú
                </button>
                <div class="collapse d-md-block" id="sidebarMenu">
                    <ul class="nav flex-column">
                        @if (Auth::check())
                            <li class="nav-item">
                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#submenu-{{ Auth::user()->name }}">
                                    <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                                </a>
                                <div class="collapse" id="submenu-{{ Auth::user()->name }}">
                                    <ul class="list-unstyled ms-3">
                                        @foreach (['materias' => 'book', 'juegos' => 'controller', 'proyectos' => 'briefcase'] as $section => $icon)
                                            <li>
                                                <a class="nav-link" href="{{ route('menu.section', ['name' => strtolower(Auth::user()->name), 'section' => $section]) }}">
                                                    <i class="bi bi-{{ $icon }}"></i> {{ ucfirst($section) }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-danger" href="#" onclick="logout()">
                                    <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </nav>

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

    <footer><p>&copy; 2025 Mi Sitio. Todos los derechos reservados.</p></footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function logout() {
            fetch('/logout', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
                credentials: 'same-origin'
            })
            .then(response => {
                if (response.ok) { window.location.href = '/login'; }
                else { alert('Error al cerrar sesión'); }
            })
            .catch(error => { alert('Error al realizar la solicitud'); });
        }
    </script>
</body>
</html>
