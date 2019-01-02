@extends('layouts.home.master')

@section('content')

<div class="price-tables">
    <div class="container register-form-step-plan active">


        <h1 class="title_plan">Selecciona tu método de pago</h1>
    
        <div class="price-table">
            <div class="row center-block" >
                <div style="">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-8"> 
                            <div class="row  justify-content-center">
                                <div  style="overflow:hidden;margin-bottom:2em;">
                                    <div class="col-sm-6 align-self-center">
                                        <h3>Mensualmente</h3>
                                        <span>$29</span>
                                    </div>
                                    <div class="col-sm-6 align-self-center">
                                        <h3>Anualmente</h3>
                                        <span>$290</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="payment-card" >
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <form id="frm-pagar-subscripcion">
                                                        <div class="form-group">
                                                            <label >Correo Electrónico</label> 
                                                            <input class="form-control" type="text" size="50" data-culqi="card[email]" id="card[email]">
                                                            
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Número de tarjeta</label>
                                                            <input class="form-control" type="text" size="20" data-culqi="card[number]" id="card[number]">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>CVV</label>
                                                            <input class="form-control"  type="text" size="4" data-culqi="card[cvv]" id="card[cvv]">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Fecha expiración (MM/YYYY)</label>
                                                            <input size="2" data-culqi="card[exp_month]" id="card[exp_month]">
                                                            <span>/</span>
                                                            <input size="4" data-culqi="card[exp_year]" id="card[exp_year]">
                                                        </div>
                                                        <button id="buyButton" type="submit" class="btn btn-primary pull-right">PAGAR</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2"></div>
                </div>
                
            </div>
        </div>
    </div>
</div>


@endsection('content')

@section('scripts')
    
<script src="https://checkout.culqi.com/v2"></script>
<script>
    Culqi.publicKey = 'pk_test_xwCI0lmt8MrIT9N1';
    Culqi.init();

    $('#frm-pagar-subscripcion').on('submit', function(e) {
        // Crea el objeto Token con Culqi JS
        
        Culqi.createToken();
        e.preventDefault();
        
        console.log('llego aquí');
    });
    function culqi() {
        if (Culqi.token) { // ¡Objeto Token creado exitosamente!
            var token = Culqi.token.id;
            alert('Se ha creado un token:' + token);
            console.log('llego '+token );
            $.ajax({
                type: "POST",
                url: '/checkout',
                data: {
                    token: token
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: "json",
                success: function(item){
                }
            });
        } else { // ¡Hubo algún problema!
            // Mostramos JSON de objeto error en consola
            console.log(Culqi.error);
            alert(Culqi.error.user_message);
        }
    };
    
</script>
@endsection