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
            <!-- Icon !-->
            <div class="row section_landing">
                <div class="col-sm-12" class="text-center">
                    <img src="{{ URL::to('home/images/subscription/completed_basic.png') }}" alt="basic-logo" class="img-responsive center-block" >
                </div>
            </div>
            <!-- Message and button !-->
            <div class="row section_landing">
                <div class=" col-sm-12 "   >
                    <h2 class=" brand-color text-center center-block" style="font-weight:700;width:50%;">ˇFelicidades!</h2>
                    <h2 class=" brand-color text-center center-block" style="font-weight:700;width:50%;">Ya estas suscrito al Plan Basic</h2>
                </div>

                <div class=" col-sm-12  "   >
                    <h3 class="light-shade-color text-center center-block " style="width:40%; font-weight:300;"><a href="#" class="brand-color" >Inicia sesión</a>en tu Plan Basic.</h3>
                </div>
            </div>
        </div>
    </div>
@endsection
