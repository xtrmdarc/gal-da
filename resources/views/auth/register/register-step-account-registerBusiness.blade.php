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
                                <p>Empezarás a administrar de una manera más rápida tu negocio y tener todo en orden.</p>
                                <p>Galda se compromente ayudarte a sacarle el máximo a tu negocio.</p>
                            </div>
                            <form method="POST" action="{{ route('web.auth.register.store_account_business') }}">
                                @csrf
                                <div class="form-group">
                                    <label>Nombre del Negocio</label>
                                    <input id="name" type="text" class="form-control{{ $errors->has('name_business') ? ' is-invalid' : '' }}" name="name_business" value="{{ old('name_business') }}" maxlength="30" required autofocus placeholder="Nombre del Negocio" autocomplete="off">

                                    @if ($errors->has('name_business'))
                                        <span class="invalid-feedback">
                                                <strong>{{ $errors->first('name_business') }}</strong>
                                            </span>
                                    @endif
                                </div>
                                @if (count($errors) > 0)
                                    <div class="form-group">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <span class="invalid-feedback">
                                                    <strong>{{ $error }}</strong>
                                                </span>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div style="color:#555;margin-bottom:20px;" >
                                    <label >Tu nombre de usuario</label>
                                    <p class="text-center" id="usuario">admin@<span id="empresa_usuario"></span></p>  
                                </div>
                                <input type="hidden" name="usuario" id="ip_usuario" >
                                <input type="hidden" name="empresa_usuario" id="ip_empresa_usuario" >
                                
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

@section('scripts')
<script type="text/javascript">

    // (function(){
        
    //     let input = document.getElementById('name');
        
    //     console.log(input);
    //     input.onkeyup = function(){
    //         let empresa_nombre = document.getElementById(e.target).val().replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-');
    //     document.getElementById('empresa_usuario').text(empresa_nombre);
    //     }
    
    // })();
    
    $('#name').on('keyup',function(e){
        let empresa_nombre = $(e.target).val().replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
        console.log(empresa_nombre);
        $('#empresa_usuario').text(empresa_nombre);
        $('#ip_usuario').val('admin@'+empresa_nombre);
        $('#ip_empresa_usuario').val(empresa_nombre);
    });
</script>
@endsection
