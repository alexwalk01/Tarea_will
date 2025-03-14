@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('Telefono') }}</label>

                            <div class="col-md-6">
                                <input id="phone" type="phone" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone">

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ ('Password') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="security_question_1" class="col-md-4 col-form-label text-md-end">Pregunta de Seguridad 1</label>
                            <div class="col-md-6">
                                <select id="security_question_1" class="form-control @error('security_question_1') is-invalid @enderror" name="security_question_1" required>
                                    <option value="favorite_movie">¿Cómo se llama su película favorita?</option>
                                </select>
                                @error('security_question_1')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="security_answer_1" class="col-md-4 col-form-label text-md-end">Respuesta de Seguridad 1</label>
                            <div class="col-md-6">
                                <input id="security_answer_1" type="text" class="form-control @error('security_answer_1') is-invalid @enderror" name="security_answer_1" required>
                                @error('security_answer_1')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="security_question_2" class="col-md-4 col-form-label text-md-end">Pregunta de Seguridad 2</label>
                            <div class="col-md-6">
                                <select id="security_question_2" class="form-control @error('security_question_2') is-invalid @enderror" name="security_question_2" required>
                                    <option value="first_pet">¿Cuál es el nombre de su primera mascota?</option>
                                </select>
                                @error('security_question_2')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="security_answer_2" class="col-md-4 col-form-label text-md-end">Respuesta de Seguridad 2</label>
                            <div class="col-md-6">
                                <input id="security_answer_2" type="text" class="form-control @error('security_answer_2') is-invalid @enderror" name="security_answer_2" required>
                                @error('security_answer_2')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="privacy-check" onchange="toggleRegisterButton()">
                                    <label class="form-check-label" for="privacy-check">
                                        Acepto el <a href="#" target="_blank">aviso de privacidad</a>.
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" id="register-button" disabled>
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleRegisterButton() {
        const privacyCheck = document.getElementById('privacy-check');
        const registerButton = document.getElementById('register-button');
        registerButton.disabled = !privacyCheck.checked;
    }
</script>
@endsection
