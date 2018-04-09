@extends('layouts.home.master')

@section('content')
    <hr>
    <header id="header-register">
        <ol class="register-phases card-center">
            <li><a href="/"><img class="logo-p" src="{{ URL::to('home/images/ico/icono1.png') }}" alt="logo">Crear una Cuenta</a></li>
            <li><a href="/"><img class="logo-p" src="{{ URL::to('home/images/ico/icono2.png') }}" alt="logo">Selecciona tu plan</a></li>
            <li><a href="/"><img class="logo-p" src="{{ URL::to('home/images/ico/icono3.png') }}" alt="logo">Metodo de Pago</a></li>
        </ol>
    </header>

    <!-Create a account->
    <div id="main-wrapper-auth" class="background-gray-auth">
        <div class="unix-login">
            <div class="container-fluid-auth">
                <div class="row justify-content-center-auth">
                    <div class="col-lg-4 card-center">
                        <div class="auth-content card-auth">
                            <div class="login-form-auth">
                                <h4>Register</h4>
                                <form method="POST" action="{{ route('register') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label>User Name</label>
                                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus placeholder="User Name">

                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Email address</label>
                                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required placeholder="Email">

                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="Password">

                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="password-confirm" class="">Confirm Password</label>

                                        <div class="">
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="Confirm Password">
                                        </div>
                                    </div>

                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> Agree the terms and policy
                                        </label>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30" disabled>
                                        Siguiente
                                    </button>

                                    <div class="register-link-auth m-t-15 text-center">
                                        <p>Already have account ? <a href="{{ route('login') }}"> Sign in</a></p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-Selecto your Plan->
    <div id="main-wrapper-auth" class="background-gray-auth">
        <div class="unix-login">
            <div class="container-fluid-auth">
                <div class="row justify-content-center-auth">
                    <div class="col-lg-4 card-center">
                        <div class="auth-content card-auth">
                            <div class="login-form-auth">
                                <h4>Register</h4>
                                <form method="POST" action="{{ route('register') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label>User Name</label>
                                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus placeholder="User Name">

                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Email address</label>
                                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required placeholder="Email">

                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="Password">

                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="password-confirm" class="">Confirm Password</label>

                                        <div class="">
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="Confirm Password">
                                        </div>
                                    </div>

                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> Agree the terms and policy
                                        </label>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30" disabled>
                                        Siguiente
                                    </button>

                                    <div class="register-link-auth m-t-15 text-center">
                                        <p>Already have account ? <a href="{{ route('login') }}"> Sign in</a></p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-Payment Method->
    <div id="main-wrapper-auth" class="background-gray-auth">
        <div class="unix-login">
            <div class="container-fluid-auth">
                <div class="row justify-content-center-auth">
                    <div class="col-lg-4 card-center">
                        <div class="auth-content card-auth">
                            <div class="login-form-auth">
                                <h4>Register</h4>
                                <form method="POST" action="{{ route('register') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label>User Name</label>
                                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus placeholder="User Name">

                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Email address</label>
                                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required placeholder="Email">

                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="Password">

                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="password-confirm" class="">Confirm Password</label>

                                        <div class="">
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="Confirm Password">
                                        </div>
                                    </div>

                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> Agree the terms and policy
                                        </label>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30" disabled>
                                        Siguiente
                                    </button>

                                    <div class="register-link-auth m-t-15 text-center">
                                        <p>Already have account ? <a href="{{ route('login') }}"> Sign in</a></p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection('content')