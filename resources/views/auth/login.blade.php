@extends('layouts.app')

@section('content')

<div class="container d-flex align-items-start mt-3 " @style(['width: 850px'])>

    <div class="row justify-content-center mt-0">

        <div class="d-flex justify-content-end mt-5 ps-5">
            <div class="container d-flex justify-content-end ps-5">
            <div class="row ps-5 d-flex" @style(['width: 700px'])>
                <div class="col-7">
                    <img src="{{ asset('assets/logogbcs-texto.jpg') }}" @style(['width: 700px'])>
                </div>
                <div class="col-5 mb-4">
                    <img  src="{{ asset('assets/ISC.png') }}" @style(['width: 78px'])>
                </div>
            </div>
            </div>
        </div>



        <div class="col-md-8 d-flex justify-content-center mt-4" @style(['width: 850px'])>
            <div class="card shadow-lg" @style(['width: 500px'])>
                <div class="card-header d-flex justify-content-center text-white" @style(['background-color: #9F2241'])>{{ __('Iniciar Sesión') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                        <label for="email" class="col-md-4 col-form-label text-md-end">Correo Electrónico</label>

                            <div class="col-md-6 w-100">
                                <input id="email" type="email" placeholder="Ingresa tu Correo Electrónico" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>Estas credenciales no coinciden</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">

                            <label for="password" class="col-md-3 col-form-label text-md-end">Contraseña</label>

                            <div class="col-md-6 w-100 input-group">
                                <input id="password" type="password" placeholder="Ingresa tu Contraseña" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password"><span class="input-group-text" id="togglePassword"><i class="bi-eye-fill bi-black" id="eyeIcon" style="color: #9F2241"></i></span>
                                
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3 pe-5">
                            <div class="col-12 container d-flex justify-content-start ">
                                <div class="form-check">
                                    <input class="form-check-input" @style(['border-color: #9F2241']) type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Recuérdame') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-0  ps-0 d-flex justify-content-center">
                            <div class="col-md-8 d-grid gap- ps-0 w-100">
                                <button type="submit" class="btn btn-primary container-fluid" @style(['background-color: #9F2241', 'hover:color:#640D5F'])>
                                    {{ __('Acceder') }}
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
        // revelar contraseña script
        const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');
    const eyeIcon = document.querySelector('#eyeIcon');

    togglePassword.addEventListener('click', () => {
        // Toggle the type attribute
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        
        // Cambiar el ícono según el tipo de input
        if (type === 'password') {
            eyeIcon.classList.remove('bi-eye-slash-fill');
            eyeIcon.classList.add('bi-eye-fill');
        } else {
            eyeIcon.classList.remove('bi-eye-fill');
            eyeIcon.classList.add('bi-eye-slash-fill');
        }
    });
</script>



@endsection
