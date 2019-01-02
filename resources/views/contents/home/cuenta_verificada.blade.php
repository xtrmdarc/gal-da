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
                <img src="{{ URL::to('home/images/mail/verified_mail_logo.png') }}" alt="galda-logo" class="img-responsive center-block" >
            </div>
        </div>
        <!-- Message and button !-->
        <div class="row section_landing">
            <div class=" col-sm-12 "   >
                <h2 class=" light-shade-color text-center center-block" style="font-weight:700;width:50%;">Tu cuenta ha sido verificada! Ya puedes empezar a utilizar GAL-DA</h2>
            </div>
            <div class=" col-sm-12 section_landing "   >
                <a href="/login"><h2 class="brand-color text-center center-block" style="font-weight:700;width:50%;">Inicia sesión</h2></a>
            </div>
            
            
        </div>
    </div>
</div>

@endsection