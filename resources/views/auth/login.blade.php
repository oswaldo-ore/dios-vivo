@extends('layout.app')

@section('content-app')
<div class="container pt-10">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="row mb-6">
                <div class="col-auto m-auto">
                    <img src="{{asset('assets/media/dios-vivo-logo.png')}}" width="auto" height="200" alt="">
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        Iniciar sesion
                    </div>
                </div>

                <div class="card-body">

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="ci" class="col-md-4 col-form-label text-md-end">Carnet identidad</label>

                            <div class="col-md-6">
                                <input id="ci" type="number" class="form-control @error('ci') is-invalid @enderror" name="ci" value="{{ old('ci') }}" required autocomplete="off" autofocus>
                                @error('ci')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">Contraseña</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>



                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                   Iniciar sesión
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
