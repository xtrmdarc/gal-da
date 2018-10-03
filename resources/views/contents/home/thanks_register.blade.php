@extends('layouts.home.master_h_f_empty')

@section('content')
<style>
    body,html{
        height: 100%;
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
                <img src="{{ URL::to('home/images/mail/mail-set-chispas.png') }}" alt="galda-logo" class="img-responsive center-block" >
            </div>
        </div>
        <!-- Message and button !-->
        <div class="row section_landing">
            <div class=" col-sm-12 "   >
                <span class=" brand-color text-center center-block" style="font-size:2em;font-weight:700;line-height:0.8em;width:50%;">Te enviamos un correo de verificación a testfinal@mail.com</span>
            </div>

            <div class=" col-sm-12  section_landing"   >
                <span class="light-shade-color text-center center-block " style="font-size:1em;line-height:1.2em;width:40%;">Si no ves el correo en tu bandeja, por favor verifica el spam. Si no puedes verlo aun asi, haz clic <b class="brand-color"> aqui</b>  para enviarte nuevamente el correo.</span>
            </div>
            <div class=" col-sm-12  section_landing"   >
                <span class="light-shade-color text-center center-block " style="font-size:1em;line-height:1.2em;width:40%;">¿No eres tú? <span class="brand-color" style="font-weight:400"> <a  style="color:inherit" href="{{ route('logout') }}"   onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">Cierra sesión.</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                    </form></span>
                 </span> 
            </div>
        </div>
    </div>
</div>

@endsection