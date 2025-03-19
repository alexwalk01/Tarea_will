@extends('layouts.app')

@section('cssLogin')
    <!-- Importa la hoja de estilo de la sección -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/styleLogin.css') }}">
@endsection

@section('content')
<div class="container d-flex align-items-center justify-content-center vh-100">
    <div class="card shadow-lg p-4" style="max-width: 380px; width: 100%; border-radius: 20px; overflow: hidden; background: #ffffff;">

        <div>
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
        </div>

        <!-- Mensaje de sesión cerrada -->
        <div id="session-message" class="alert alert-warning" style="display: none;">
            Tu sesión ha sido cerrada porque se inició sesión en otro dispositivo.
        </div>

        <div class="text-center mb-4">
            <h3 class="fw-bold text-primary">{{ __('Bienvenido') }}</h3>
            <p class="text-muted">{{ __('Inicia sesión para continuar') }}</p>
        </div>

        <div class="card-body">
            @if(session('message'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif


            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">{{ __('Correo Electrónico') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">{{ __('Contraseña') }}</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg" style="border-radius: 10px; background: #6a11cb; border: none;">{{ __('Iniciar sesión') }}</button>
                </div>

                <div class="text-center mt-4">
                    @if (Route::has('password.request'))
                        <a class="text-decoration-none text-primary fw-bold" href="{{ route('password.request') }}">
                            {{ __('¿Olvidaste tu contraseña?') }}
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Mostrar el mensaje de sesión cerrada por 5 segundos
    window.onload = function() {
        var sessionMessage = document.getElementById('session-message');
        if (sessionMessage) {
            sessionMessage.style.display = 'block'; // Mostrar el mensaje
            setTimeout(function() {
                sessionMessage.style.display = 'none'; // Ocultar el mensaje después de 5 segundos
            }, 5000);
        }
    };
</script>

@endsection
