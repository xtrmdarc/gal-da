@extends('layouts.home.master')

@section('content')

        <!-- Main wrapper  -->
<div id="main-wrapper-auth" class="background-gray-auth">

    <div class="unix-login">
        <div class="container-fluid-auth">
            <div class="row justify-content-center-auth">
                <div class="col-lg-4 card-center">
                    <div class="auth-content card-auth">
                        <div class="login-form-auth">
                            <h4 style="margin-bottom: 10px;">Empieza con nuestro plan gratis para siempre</h4>
                            <div class="register-link-auth m-t-15 text-center">
                                    <p>Empieza a hacer crecer tu negocio <br>
                                ¿Ya mencionamos que es gratis por siempre?</p>
                            </div>
                            <form method="POST" action="{{ route('web.auth.register.store_account') }}" style="margin-top:20px;">
                                @csrf
                                <input type="hidden" name="name_business">
                                <div class="form-group">
                                    <label>CORREO ELECTRÓNICO</label>
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus placeholder="Correo">
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>CONTRASEÑA</label>
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="Contraseña">

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <button type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30">Crea tu cuenta</button>
                                <div class="register-link-auth m-t-15 text-center">
                                    <p>¿Ya tienes una cuenta? <a href="{{ route('login') }}"> Inicia Sesión</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- End Wrapper -->
{{--/*
<div id="register-step-account" >
    <div class="container">
        <div class="row">
            <div class="col-md-6 " style="background-color: #1fbdb7;">
                <div class="">
                    <img class="" ng-src="" src="">
                    <div class="" ui-view="">
                        <div class="">
                            <div class="">
                                <img ng-src="" width="160" height="160" class="" src="/">

                                <div class="">
                                    I have used Leadpages and Unbounce, and can confidently say that Landing Lion is the easiest to use and has the best customer experience out there. Landing Lion nails both of those and I wouldn�t change a thing.
                                </div>

                                <div class="">Dan D'Aquisto</div>
                                <div class="">CRO at 2ULaundry</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="">
                    <header class="">
                        <img class="" src="">
                        <div class="">
                            Get started on our forever free plan
                        </div>
                        <div class="">
                            Start building beautiful landing pages with no credit card required.
                            <br>
                            Did we mention free forever?
                        </div>
                    </header>

                    <form class="" name="" novalidate="novalidate">
                        <fieldset>
                            <input class="" type="email" name="user-email" auto-select="" placeholder="Email address" ng-model="user.email" required="">
                        </fieldset>

                        <fieldset>
                            <input class="" name="user-password" placeholder="Password" ng-model="user.password" required="" ng-minlength="8" type="password">
                        </fieldset>

                        <div class="" fx-s-mb="4">
                            By signing up, you agree to our
                            <span class="">Terms of Service</span> and
                            <span class="">Privacy Policy</span>.
                        </div>

                        <button class="" type="submit"">
                        Create your account
                        </button>
                    </form>

                    <div class="">
                        Already have an account?
                        <span class="">Log in</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
*/--}}

@endsection('content')

