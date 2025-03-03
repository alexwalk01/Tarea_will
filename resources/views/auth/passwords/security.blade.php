@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Recuperar Contraseña') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('security.verify') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="security_answer_1" class="form-label">¿Cómo se llama su película favorita?</label>
                            <input type="text" id="security_answer_1" name="security_answer_1" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="security_answer_2" class="form-label">¿Cuál es el nombre de su primera mascota?</label>
                            <input type="text" id="security_answer_2" name="security_answer_2" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Verificar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
