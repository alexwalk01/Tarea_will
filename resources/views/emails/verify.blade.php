<!DOCTYPE html>
<html>
<head>
    <title>Confirmación de inicio de sesión</title>
</head>
<body>
    <p>Hola {{ $user->name }},</p>
    <p>Alguien ha intentado iniciar sesión en tu cuenta ahora mismo. ¿Fuiste tú?</p>
    <p>Si fuiste tú, haz clic en el siguiente enlace para confirmar:</p>
    <a href="{{ route('verify.email', ['verificationCode' => $verificationCode]) }}">Confirmar inicio de sesión</a>
    <p>Si no fuiste tú, ignora este correo electrónico.</p>
    <p>Este enlace expirará en 2 minutos.</p>
</body>
</html>