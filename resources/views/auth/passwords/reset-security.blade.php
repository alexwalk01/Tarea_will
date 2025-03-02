@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header text-center font-weight-bold" style="background-color: #343a40; color: white;">
                    {{ __('🔑 Nueva Contraseña') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('security.update') }}">
                        @csrf
                        <input type="hidden" name="email" value="{{ $email }}">

                        <!-- Campo Nueva Contraseña -->
                        <div class="mb-4">
                            <label for="password" class="form-label fw-bold">🔒 Nueva Contraseña</label>
                            <div class="input-group">
                                <input type="password" id="password" name="password" 
                                       class="form-control @error('password') is-invalid @enderror" required 
                                       placeholder="Ingrese su nueva contraseña">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    👁️
                                </button>
                            </div>

                            @error('password')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <!-- Campo Confirmar Contraseña -->
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label fw-bold">🔄 Confirmar Contraseña</label>
                            <div class="input-group">
                                <input type="password" id="password_confirmation" name="password_confirmation" 
                                       class="form-control" required placeholder="Confirme su contraseña">
                                <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                    👁️
                                </button>
                            </div>
                        </div>

                        <!-- Botón Actualizar Contraseña -->
                        <div class="text-center">
                            <button type="submit" class="btn text-white px-4 py-2" 
                                    style="background-color: #fd7e14; border-radius: 8px; font-size: 1.1rem;">
                                🔄 {{ __('Actualizar Contraseña') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script para mostrar/ocultar contraseña -->
<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        let passwordField = document.getElementById('password');
        passwordField.type = passwordField.type === 'password' ? 'text' : 'password';
    });

    document.getElementById('toggleConfirmPassword').addEventListener('click', function () {
        let confirmPasswordField = document.getElementById('password_confirmation');
        confirmPasswordField.type = confirmPasswordField.type === 'password' ? 'text' : 'password';
    });
</script>
@endsection

