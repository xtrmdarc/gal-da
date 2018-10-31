@extends('layouts.home.master_h_f_empty')

@section('content')
<style>
    body,html{
        height: 100%;
    }
    h1,h2,h3,h4,h5,h6{
        font-family: 'Montserrat', sans-serif !important;
    }
</style>
<link href="{{ URL::to('application/css/lib/sweetalert/sweetalert.css') }}" rel="stylesheet">
<div class="background-light-brand" style="height:100%">
    <div class="background-light-brand">

    
        <!-- Logo !-->
        <div class="row "  >
            <div class="col-sm-12" class="text-center">
                <img src="{{ URL::to('home/images/logo-1.png') }}" alt="galda-logo" class="img-responsive center-block section_landing" width="200px" height="80px">
            </div>
        </div>          
        <!-- Message and button !-->
        <div class="row section_landing">
            <div class=" col-sm-12 "   >
                <h2 class=" brand-color text-center center-block" style="font-weight:700;width:50%;">Tu cuenta ha sido verificada!</h2>
            </div>

            <div class=" col-sm-12  "   >
                <h3 class="light-shade-color text-center center-block " style="width:40%; font-weight:300;">Para terminar con el proceso de registro, configura tu contraseña.</h3>
            </div>
            <div class=" col-sm-12  " >
                <form action="{{route('activarSubUsuario')}}"  method="POST">
                    <div class="col-sm-6 offset-sm-3"> 
                        <input type="hidden" name="email" value="{{$user->email}}">
                        <input type="hidden" name="verifyToken" value="{{$user->verifyToken}}">
                        <div class="form-group">
                            <label>Contraseña</label>
                            <input id="name" type="text" class="form-control" name="password1" value="" required autofocus placeholder="Contraseña">
                        </div>
                        <input type="submit" class="btn btn-primary" value="Enviar">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')
    <script type="text/javascript" src="{{ URL::to('application/js/lib/sweetalert/sweetalert.min.js') }}"></script>
    <script>
        $('#btn_resend_verimail').on('click',function(){
            //window.location.reload();
            
            $.ajax({
                dataType: 'JSON',
                type: 'POST',
                url: '/reSendVerificationMail',
                data: {
                    id_user: {!!$user['id_usu']!!}
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    if(data == 1)
                    swal( "Listo","Hemos re enviado el correo de verifiación","success","Perfecto");
                    
                },
                error: function(jqXHR, textStatus, errorThrown){
                    console.log(errorThrown + ' ' + textStatus);
                }  
            });
            
        });
    </script>
   
@endsection