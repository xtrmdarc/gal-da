@extends('layouts.home.master')

@section('content')

    <div id="main-wrapper-auth" class="background-gray-auth">
        <div class="unix-login">
            <div class="container-fluid-auth">
                <div class="row justify-content-center-auth">
                    <div class="col-lg-4 card-center">
                        <div class="auth-content card-auth">
                            <div class="login-form-auth">
                                <h4>Cambiar Contrase&ntilde;a</h4>
                                <form method="POST" action="{{ route('password.request') }}">
                                    @csrf

                                    <input type="hidden" name="token" value="{{ $token }}">

                                    <div class="form-group">
                                        <label for="email">E-Mail Address</label>
                                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email or old('email') }}" required autofocus>
                                            @if ($errors->has('email'))
                                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                            @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="password">Password</label>

                                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                            @if ($errors->has('password'))
                                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                            @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="password-confirm">Confirm Password</label>
                                            <input id="password-confirm" type="password" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation" required>
                                            @if ($errors->has('password_confirmation'))
                                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                            @endif
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30">
                                        Cambiar Contrase&ntilde;a
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
