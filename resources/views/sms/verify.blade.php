@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header text-center font-weight-bold" style="background-color: #343a40; color: white;">
                    {{ __('🔐 Verificar Código de Seguridad') }}
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success d-flex align-items-center" role="alert">
                            <i class="fas fa-check-circle me-2"></i> <!-- Ícono de éxito -->
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i> <!-- Ícono de error -->
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('sms.verify_code') }}">
                        @csrf

                        {{-- Mantener el teléfono en la sesión para evitar que se pierda --}}
                        <input type="hidden" name="phone" value="{{ session('phone', old('phone')) }}">

                        <!-- Campo de Código de Verificación -->
                        <div class="mb-4">
                            <label for="codigo" class="form-label fw-bold">{{ __('🔑 Código de Verificación') }}</label>
                            <input id="codigo" type="text" class="form-control @error('codigo') is-invalid @enderror" 
                                   name="codigo" value="{{ old('codigo') }}" required autofocus
                                   placeholder="Ingresa el código recibido">

                            @error('codigo')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <!-- Botón de Verificación -->
                        <div class="text-center">
                            <button type="submit" class="btn text-white px-4 py-2" 
                                    style="background-color: #28a745; border-radius: 8px; font-size: 1.1rem;">
                                ✅ {{ __('Verificar Código') }}
                            </button>
                        </div>
                    </form>

                    <!-- Opción de reenviar código -->
                    <div class="text-center mt-3">
                        <p>¿No recibiste el código? <a href="{{ route('sms.form') }}" class="fw-bold text-primary">📩 Reenviar código</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
