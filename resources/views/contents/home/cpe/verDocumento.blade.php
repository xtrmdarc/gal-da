@extends('layouts.home.master_h_f_empty')

@section('content')

    <?php
    date_default_timezone_set('America/Lima');
    setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
    $fecha = date("d-m-Y");
    $fechaa = date("m-Y");
    //$logo_g = $id_empre_logo;
    //$url = Storage::disk('s3')->url($logo_g);
    //    $logo_g = $url;
    ?>

    <style>
        .bootstrap-datetimepicker-widget{

            z-index: 99999 !import;
        }
    </style>

    <div id="main-wrapper-auth" class="background-gray-auth">

        <div class="unix-login">
            <div class="container-fluid-auth">
                <div class="row justify-content-center-auth">
                    <div class="col-lg-4 card-center max-w">
                        <div class="auth-content card-auth">
                            <div class="login-form-auth">
                                <h4>Documento Electr&oacute;nico</h4>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3 col-xs-12 s-col">
                                        {{--/*
                                           <div class="logotipo c-logo">
                                            <img  src="{{ !empty($logo_g) ? $logo_g : '/application/images/tu_logo.png' }}" style="width: 80px;max-height:64px;" alt="homepage" class="dark-logo" />
                                        </div>
                                        */--}}
                                    </div>
                                    <div class="col-sm-3 col-xs-12 s-col">
                                        <a type="button" class="btn btn-primary b_c" href="{{route('cpe')}}"><i class="fa fa-angle-left icon-left"></i> Volver</a>
                                    </div>
                                    <form method="post" enctype="multipart/form-data" action="/cpe_descargar_pdf" target="pdf_d" >
                                        @csrf
                                        <div class="col-sm-3 col-xs-12 s-col">
                                            <input type="hidden" name="x_pdf" value="{{$v_index_x_cuenta}}">
                                            <input type="hidden" name="id_emp" value="{{$id_empre_ruc}}">
                                            <input id="b_pdf" type="submit" class="btn btn-primary" value="Ver PDF">
                                        </div>
                                    </form>
                                    <form method="post" enctype="multipart/form-data" action="/cpe_descargar">
                                        @csrf
                                            <div class="col-sm-3 col-xs-12 s-col">
                                                <input type="hidden" name="x_p" value="{{$path_xml}}">
                                                <input type="submit" class="btn btn-primary" value="Descargar XML">
                                            </div>
                                    </form>
                                </div>
                                <hr>
                                <div class="row">
                                    <iframe id="pdf_d" name="pdf_d" style="width: 100%;height: 1000px; display: none;"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

 <script type="text/javascript">
     $(function() {
         var btn_pdf_container = $("#b_pdf");

         btn_pdf_container.on("click",function() {
             $('#pdf_d').fadeIn();
         });
     });
 </script>
@endsection('content')