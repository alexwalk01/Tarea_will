@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verificar Código') }}</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('sms.verify') }}">
                        @csrf

                        {{-- Mantener el teléfono en la sesión para evitar que se pierda --}}
                        <input type="hidden" name="phone" value="{{ session('phone', old('phone')) }}">

                        <div class="row mb-3">
                            <label for="codigo" class="col-md-4 col-form-label text-md-end">{{ __('Código de Verificación') }}</label>

                            <div class="col-md-6">
                                <input id="codigo" type="text" class="form-control @error('codigo') is-invalid @enderror" name="codigo" value="{{ old('codigo') }}" required autofocus>

                                @error('codigo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-dark">
                                    {{ __('Verificar Código') }}
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="text-center mt-3">
                        <p>¿No recibiste el código? <a href="{{ route('sms.form') }}">Reenviar código</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection