@extends('layouts.app')

@section('content')

<navbar @auth auth @endauth></navbar>

{{-- Container --}}
<div class="container pt-5 mt-5">
    {{-- Row --}}
    <div class="row justify-content-center">
        {{-- Col --}}
        <div class="ccol-md-7 col-lg-6 col-xl-5">
            {{-- Card --}}
            <div class="card">
                {{-- Card body --}}
                <div class="card-body py-5 px-4">
                    {{-- Title --}}
                    <h1 class="text-center h3 mb-5">Iniciar sesión</h1>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group">
                            <ls-input id="email" name="email" type="email" placeholder="Email" req value="{{ old('email') }}" @error('email') invalid @enderror></ls-input>
                                
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <ls-input id="password" name="password" type="password" placeholder="Contraseña" req value="{{ old('password') }}" @error('password') invalid @enderror></ls-input>

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mt-5 mb-0">
                            <button type="submit" class="btn button-primary btn-block">
                                {{ __('Login') }}
                            </button>
                        </div>
                        
                        <div class="form-group my-5">
                            <hr>
                        </div>

                        {{-- Olvidaste tu Contraseña --}}
                        <div class="form-group">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>

                    </form>
                    {{-- /.Form --}}
                </div>
                {{-- /.Card body --}}
            </div>
            {{-- /.Card --}}
        </div>
        {{-- /.Col --}}
    </div>
    {{-- /.Row --}}
</div>
{{-- Container --}}

@endsection
