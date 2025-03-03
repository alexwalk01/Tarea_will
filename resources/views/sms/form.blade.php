@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header text-center font-weight-bold" style="background-color: #343a40; color: white;">
                    {{ __('📲 Enviar SMS de Verificación') }}
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

                    <form method="POST" action="{{ route('sms.send') }}">
                        @csrf

                        <!-- Campo para ingresar el número de teléfono -->
                        <div class="mb-4">
                            <label for="phone" class="form-label fw-bold">{{ __('📞 Número de Teléfono') }}</label>
                            <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" 
                                   name="phone" value="{{ old('phone') }}" required autocomplete="phone" autofocus
                                   placeholder="Ej: 919 456 7890">

                            @error('phone')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <!-- Botón de envío con color llamativo -->
                        <div class="text-center">
                            <button type="submit" class="btn text-white px-4 py-2" 
                                    style="background-color: #ff5722; border-radius: 8px; font-size: 1.1rem;">
                                🚀 {{ __('Enviar Código') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
