@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header text-center font-weight-bold" style="background-color: #343a40; color: white;">
                        {{ __('🔄 Restablecer Contraseña') }}
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Correo Electrónico') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email') ?? '' }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn" style="background-color: #00aae4; color: white;">
                                    {{ __('Enviar Enlace de Restablecimiento') }}
                                </button>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6 offset-md-4">
                                <a href="{{ route('sms.form') }}" class="btn" style="background-color: #ff5722; color: white;">
                                    {{ __('Recuperar por SMS') }}
                                </a>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6 offset-md-4">
                                <a href="{{ route('security.form') }}" class="btn" style="background-color: #ff5722; color: white;">
                                    {{ __('Recuperar por Preguntas de Seguridad') }}
                                </a>
                            </div>
                        </div>

                    
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
