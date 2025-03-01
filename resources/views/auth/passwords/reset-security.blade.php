@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Nueva Contraseña') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('security.update') }}">
                        @csrf
                        <input type="hidden" name="email" value="{{ $email }}">

                        <div class="mb-3">
                            <label for="password" class="form-label">Nueva Contraseña</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Actualizar Contraseña</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
