@extends('layouts.home.master_h_f_empty')

@section('content')

        <!-- Main wrapper  -->
<div id="main-wrapper-auth" class="background-gray-auth">

    <div class="unix-login">
        <div class="container-fluid-auth">
            <div class="row justify-content-center-auth">
                <div class="col-lg-4 card-center" style="margin-bottom: 50%;margin-top: 10%;">
                    <div class="auth-content card-auth">
                        <div class="login-form-auth">
                            <h4 style="margin-bottom: 10px;">Ultimo paso, dinos el nombre de tu negocio</h4>
                            <div class="register-link-auth m-t-15 text-center">
                                <p>Empezaras a administrar de una manera mas rapida tu negocio y tener todo en orden.</p>
                                <p>Galda se compromente ayudarte a sacarle el maximo a tu negocio.</p>
                            </div>
                            <form method="POST" action="{{ route('web.auth.register.store_account_business') }}">
                                @csrf
                                <div class="form-group">
                                    <label>Nombre del Negocio</label>
                                    <input id="name" type="text" class="form-control{{ $errors->has('name_business') ? ' is-invalid' : '' }}" name="name_business" value="{{ old('name_business') }}" required autofocus placeholder="Nombre del Negocio">

                                    @if ($errors->has('name_business'))
                                        <span class="invalid-feedback">
                                                <strong>{{ $errors->first('name_business') }}</strong>
                                            </span>
                                    @endif
                                </div>

                                <button type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30">¡ Potencia tu negocio !</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection('content')

