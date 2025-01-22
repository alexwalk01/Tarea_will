<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Hamburguesa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuHamburguesa">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="menuHamburguesa">
                <ul class="navbar-nav flex-column"> <!-- Añade la clase 'flex-column' para disposición vertical -->
                    @foreach ($people as $person)
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="{{ $person }}" role="button" data-bs-toggle="dropdown">
                                {{ $person }}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="{{ $person }}">
                                <li><a class="dropdown-item" href="{{ route('menu.section', [$person, 'juegos']) }}">Juegos</a></li>
                                <li><a class="dropdown-item" href="{{ route('menu.section', [$person, 'proyectos']) }}">Proyectos</a></li>
                                <li><a class="dropdown-item" href="{{ route('menu.section', [$person, 'materias']) }}">Materias</a></li>
                            </ul>
                        </li>
                    @endforeach
                </ul>
            </div>
        </nav>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
