<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Inicio de Sesión</title>
</head>
<body>
    <p>Alguien intentó iniciar sesión con tu cuenta. ¿Eras tú?</p>

    <p>
        <a href="{{ $url_yes }}" 
           style="display: inline-block; padding: 10px 20px; background-color: green; color: white; text-decoration: none; margin-right: 10px;">
           ✅ Sí, soy yo
        </a>

    <p>Si no reconoces este inicio de sesión, te recomendamos cambiar tu contraseña.</p>
</body>
</html>
