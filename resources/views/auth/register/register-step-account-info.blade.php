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
                            <h4 style="margin-bottom: 10px;">Termina de Completar estos campos</h4>
                            <div class="register-link-auth m-t-15 text-center">
                                <p>Estas cerca de empezar a cambiar tu negocio</p>
                            </div>
                            <form method="POST" action="{{ route('web.auth.register.store_account_info') }}">
                                @csrf
                                <div class="form-group">
                                    <label>Name</label>
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('nombres') }}" required autofocus placeholder="Name">

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Father Last Name</label>
                                    <input id="name" type="text" class="form-control{{ $errors->has('lastname') ? ' is-invalid' : '' }}" name="lastname" value="{{ old('ape_paterno') }}" required autofocus placeholder="Father Last Name">

                                    @if ($errors->has('lastname'))
                                        <span class="invalid-feedback">
                                                <strong>{{ $errors->first('lastname') }}</strong>
                                            </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Mother Last Name</label>
                                    <input id="m_lastname" type="text" class="form-control{{ $errors->has('m_lastname') ? ' is-invalid' : '' }}" name="m_lastname" value="{{ old('ape_materno') }}" required autofocus placeholder="Mother Last Name">

                                    @if ($errors->has('m_lastname'))
                                        <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('m_lastname') }}</strong>
                                                </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Dni</label>
                                    <input id="dni" type="text" class="form-control{{ $errors->has('dni') ? ' is-invalid' : '' }}" name="dni" value="{{ old('dni') }}" required autofocus placeholder="dni">

                                    @if ($errors->has('dni'))
                                        <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('dni') }}</strong>
                                                </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input id="phone" type="text" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone') }}" required autofocus placeholder="Phone">

                                    @if ($errors->has('phone'))
                                        <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('phone') }}</strong>
                                                </span>
                                    @endif
                                </div>

                                <button type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30">Un paso mas</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection('content')

