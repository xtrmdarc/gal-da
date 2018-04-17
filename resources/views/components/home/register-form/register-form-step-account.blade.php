<!-Create a account->
<div class="background-gray-auth register-form-step {{ $class_active or '' }}">
    <div class="unix-login">
        <div class="container-fluid-auth">
            <div class="row justify-content-center-auth">
                <div class="col-lg-4 card-center">
                    <div class="auth-content card-auth">
                        <div class="login-form-auth">
                            <h4>Register</h4>
                                <div class="form-group">
                                    <label>Name of Business</label>
                                    <input id="name" type="text" class="form-control{{ $errors->has('name_business') ? ' is-invalid' : '' }}" name="name_business" value="{{ old('name_business') }}" required autofocus placeholder="Nombre del Negocio">

                                    @if ($errors->has('name_business'))
                                        <span class="invalid-feedback">
                                                <strong>{{ $errors->first('name_business') }}</strong>
                                            </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Name</label>
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus placeholder="Name">

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input id="name" type="text" class="form-control{{ $errors->has('lastname') ? ' is-invalid' : '' }}" name="lastname" value="{{ old('lastname') }}" required autofocus placeholder="Last Name">

                                    @if ($errors->has('lastname'))
                                        <span class="invalid-feedback">
                                                <strong>{{ $errors->first('lastname') }}</strong>
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

                                <button type="button" id="btn-register-account" class="btn btn-primary btn-flat m-b-30 m-t-30" >
                                    Siguiente
                                </button>

                                <div class="register-link-auth m-t-15 text-center">
                                    <p>Already have account ? <a href="{{ route('login') }}"> Sign in</a></p>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
