<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Página no encontrada</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #2c3e50;
            color: #ecf0f1;
            font-family: 'Arial', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            text-align: center;
        }
        h1 {
            font-size: 8rem;
            margin: 0;
        }
        p {
            font-size: 1.5rem;
            margin: 10px 0 20px;
        }
        a {
            text-decoration: none;
            color: #3498db;
            font-weight: bold;
            border: 2px solid #3498db;
            padding: 10px 20px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        a:hover {
            background-color: #3498db;
            color: #ecf0f1;
        }
        img {
            max-width: 100%;
            height: auto;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div>
        <h1>404</h1>
        <p>Lo sentimos, la página que buscas no se pudo encontrar.</p>
        <a href="{{ url('/') }}">Volver al inicio</a>
        <img src="{{ asset('/img/img1.svg') }}" alt="Error 404">
    </div>
</body>
</html>
