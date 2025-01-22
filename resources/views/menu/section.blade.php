<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sección - {{ ucfirst($name) }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <!-- Breadcrumbs -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('menu.index') }}">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ ucfirst($name) }} - {{ ucfirst($section) }}</li>
            </ol>
        </nav>

        <!-- Contenido -->
        <h1>{{ ucfirst($name) }} - {{ ucfirst($section) }}</h1>
        <p>Aquí se muestran los detalles de {{ $section }} de {{ $name }}.</p>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
