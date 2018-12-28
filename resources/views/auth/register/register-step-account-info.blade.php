@extends('layouts.home.master_h_f_empty')

@section('content')

        <!-- Main wrapper  -->
<div id="main-wrapper-auth" class="background-gray-auth">

    <div class="unix-login">
        <div class="container-fluid-auth">
            <div class="row justify-content-center-auth">
                <div class="col-lg-4 card-center">
                    <div class="auth-content card-auth">
                        <div class="login-form-auth">
                            <h4 style="margin-bottom: 10px;">Termina de completar estos campos</h4>
                            <div class="register-link-auth m-t-15 text-center">
                                <p>Estas cerca de empezar a cambiar tu negocio</p>
                            </div>
                            <form method="POST" action="{{ route('web.auth.register.store_account_info') }}">
                                @csrf
                                <div class="form-group">
                                    <label>Nombre</label>
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('nombres') }}" maxlength="30" required autofocus placeholder="Nombre">

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Apellido Paterno</label>
                                    <input id="name" type="text" class="form-control{{ $errors->has('lastname') ? ' is-invalid' : '' }}" name="lastname" value="{{ old('ape_paterno') }}" maxlength="30" required autofocus placeholder="Apellido Paterno">

                                    @if ($errors->has('lastname'))
                                        <span class="invalid-feedback">
                                                <strong>{{ $errors->first('lastname') }}</strong>
                                            </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Apellido Materno</label>
                                    <input id="m_lastname" type="text" class="form-control{{ $errors->has('m_lastname') ? ' is-invalid' : '' }}" name="m_lastname" value="{{ old('ape_materno') }}" maxlength="30" required autofocus placeholder="Apellido Materno">

                                    @if ($errors->has('m_lastname'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('m_lastname') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Dni</label>
                                    <input id="dni" type="text" class="form-control{{ $errors->has('dni') ? ' is-invalid' : '' }} validanumericos" name="dni" value="{{ old('dni') }}"  maxlength="8" required autofocus placeholder="Dni">

                                    @if ($errors->has('dni'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('dni') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>País</label>
                                    {{--<span class="input-group-addon"><i class="fa fa-renren"></i></span>--}}
                                    <select name="country" id="country" class="selectpicker show-tick form-control" data-live-search="true" autocomplete="off" required="required" >
                                        <optgroup label="Seleccionar">
                                            @foreach($paises as $r)
                                                <option value="{{$r->codigo}}">{{$r->nombre}}</option>
                                            @endforeach
                                        </optgroup>
                                    </select>

                                    @if ($errors->has('country'))
                                        <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('country') }}</strong>
                                                </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Telefono/Celular</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <select name="cod_phone" id="cod_phone" class="selectpicker show-tick form-control" data-live-search="true" autocomplete="off" required="required" >
                                                <optgroup label="Seleccionar">
                                                    @foreach($cod_telefonos as $r)
                                                        @if($r->phone_codigo == $codigo_phone)
                                                            <option selected="selected" value="{{$codigo_phone}}">{{$r->nombre}}+({{$r->phone_codigo}})</option>
                                                        @else
                                                            <option value="{{$r->phone_codigo}}">{{$r->nombre}}+({{$r->phone_codigo}})</option>
                                                        @endif
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <input id="phone" type="text" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }} validanumericos" name="phone" value="{{ old('phone') }}" maxlength="13" required autofocus placeholder="Teléfono">
                                        </div>
                                    </div>

                                    @if ($errors->has('phone'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </span>
                                    @endif
                                </div>


                                <button type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30">Un paso más</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
@section('scripts')
<script type="text/javascript">
    $(function(){
        $('.validanumericos').keypress(function(e) {
            if(isNaN(this.value + String.fromCharCode(e.charCode)))
                return false;
        })
                .on("cut copy paste",function(e){
                    e.preventDefault();
                });

    });
</script>
@endsection

