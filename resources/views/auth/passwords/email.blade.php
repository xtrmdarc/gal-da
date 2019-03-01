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
                            <form id="frm-cambiar-pass" method="POST" action="{{ route('password.email') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="email">CORREO ELECTR&Oacute;NICO</label>
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}"  placeholder="Correo" required>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                    @endif
                                </div>
                                <button type="submit" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i>" class="btn btn-primary btn-flat m-b-30 m-t-30">
                                    Enviar Contrase&ntilde;a
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


@section('scripts')
    <link href="{{ URL::to('application/css/lib/sweetalert/sweetalert.css') }}" rel="stylesheet">
    <script type="text/javascript" src="{{ URL::to('application/js/lib/sweetalert/sweetalert.min.js') }}"></script>
    <script type="text/javascript" >
        
        $('#frm-cambiar-pass').on('submit',function(e){
            e.preventDefault();
            $target = $(e.target);
            
            $.ajax({
                url: $target.attr('action'),
                type: 'POST',
                dataType: 'JSON',
                data: $target.serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(){
                    console.log('Llego aqui');
                    swal( "Listo","Hemos enviado un correo para restablecer tu contraseña","success","Enviado");
                },
                complete: function(){
                    console.log('entra aqui');
                    swal( "Listo","Hemos enviado un correo para restablecer tu contraseña","success","Enviado");
                }
            })
        });

    </script>
@endsection