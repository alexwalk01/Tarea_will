@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header text-center font-weight-bold" style="background-color: #343a40; color: white;">
                    {{ __('🔒 Recuperar Contraseña') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('security.verify') }}">
                        @csrf

                        <!-- Campo de Correo Electrónico -->
                        <div class="mb-4">
                            <label for="email" class="form-label fw-bold">📧 Correo Electrónico</label>
                            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                   required placeholder="Ej: usuario@email.com">

                            @error('email')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <!-- Pregunta de Seguridad 1 -->
                        <div class="mb-4">
                            <label for="security_answer_1" class="form-label fw-bold">🎬 ¿Cómo se llama su película favorita?</label>
                            <input type="text" id="security_answer_1" name="security_answer_1" 
                                   class="form-control @error('security_answer_1') is-invalid @enderror" required 
                                   placeholder="Ej: El Señor de los Anillos">

                            @error('security_answer_1')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <!-- Pregunta de Seguridad 2 -->
                        <div class="mb-4">
                            <label for="security_answer_2" class="form-label fw-bold">🐶 ¿Cuál es el nombre de su primera mascota?</label>
                            <input type="text" id="security_answer_2" name="security_answer_2" 
                                   class="form-control @error('security_answer_2') is-invalid @enderror" required 
                                   placeholder="Ej: Rocky">

                            @error('security_answer_2')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <!-- Botón de Verificación -->
                        <div class="text-center">
                            <button type="submit" class="btn text-white px-4 py-2" 
                                    style="background-color: #28a745; border-radius: 8px; font-size: 1.1rem;">
                                ✅ {{ __('Verificar') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

