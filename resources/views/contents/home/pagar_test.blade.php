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
        <form>
            <div>
                <label>
                <span>Correo Electrónico</span>
                <input type="text" size="50" data-culqi="card[email]" id="card[email]">
                </label>
            </div>
            <div>
                <label>
                <span>Número de tarjeta</span>
                <input type="text" size="20" data-culqi="card[number]" id="card[number]">
                </label>
            </div>
            <div>
                <label>
                <span>CVV</span>
                <input type="text" size="4" data-culqi="card[cvv]" id="card[cvv]">
                </label>
            </div>
            <div>
                <label>
                <span>Fecha expiración (MM/YYYY)</span>
                <input size="2" data-culqi="card[exp_month]" id="card[exp_month]">
                <span>/</span>
                <input size="4" data-culqi="card[exp_year]" id="card[exp_year]">
                </label>
            </div>
        </form>
        
        

    </div>
</div>

@endsection

@section('scripts')
    <!-- Incluyendo .js de Culqi JS -->
    <script src="https://checkout.culqi.com/v2"></script>
    <script>
        Culqi.publicKey = 'Aquí inserta tu llave pública';
        Culqi.init();
    </script>
@endsection