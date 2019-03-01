@extends('layouts.home.master')

@section('content')

<div class="price-tables">
    <div class="container register-form-step-plan active">

        <h1 class="title_plan">Planes</h1>
    
        <div class="price-table">
            <div class="row pricing-table">

                <div class="card-pricing col-sm-4 col-md-4">
                    <div class="single-price price-one">
                        <div class="table-heading">
                            <p class="plan-name-ll">Free</p>
                            <div class="section-plan-who clearfix">
                                <p style="text-align: center;line-height: 1.3em;min-height: 1.3em"><span class="text-shade-7-0" style="font-size: 0.9em">Para el usuario curioso</span></p>
                            </div>
                            <div class="section-plan-price clearfix">
                                <h5 style="text-align: center;line-height: 1em;min-height: 1em" ><span class="price-text" style="letter-spacing: -0.02em;font-weight: bold">Gratis</span> </h5>
                            </div>
                            <div class="section-price-desc clearfix">
                                    <p style="text-align: center;line-height: 1.5em;min-height: 1.5em"><span class="text-shade-10-0" style="font-weight: bold">Pruebalo gratis por siempre</span></p>
                            </div>
                        </div>
                        <div class="section-plan-offer">
                            <br>1000 Ventas Mensuales <br>
                            Hasta 15 mesas*<br>
                            Productos Ilimitados <br>
                            1 Área de Producción <br>
                            1 Sucursal <br>
                            5 Usuarios <br>
                            1 caja <br>
                            Tablero de Control <br>
                            Clientes <br>
                            1 Informe de Ventas <br>
                            Informes de Finanzas <br>
                        </div>
                        <input type="hidden" name="plan_id" value="1" />
                    <button id="free-plan-btn" onclick="window.location.replace({{\Auth::user()->plan_id==1?'':'\'upgrade/plan/1\''}})" type="button" class="btn btn-buynow {{\Auth::user()->plan_id == 1?'btn-plan-actual':''}}" style="width: 100%;">{{\Auth::user()->plan_id==1?'PLAN ACTUAL':'EMPIEZA AHORA'}}</button>
                    </div>
                </div>
    
                <div class="card-pricing col-sm-4 col-md-4">
                        <div class="single-price price-one">
                            <div class="table-heading">
                                <p class="plan-name-ll">Basic</p>
                                <div class="section-plan-who clearfix">
                                    <p style="text-align: center;line-height: 1.3em;min-height: 1.3em"><span class="text-shade-7-0" style="font-size: 0.9em">Para pequeños y medianos restaurantes</span></p>
                                </div>
                                <div class="section-plan-price clearfix">
                                    <h5 style="text-align: center;line-height: 1em;min-height: 1em" ><span class="price-text" style="letter-spacing: -0.02em;font-weight: bold">USD 39.<span style="font-size:25px;vertical-align:top">90</span></span> <span class="text-month-price" style="">/mes</span></h5>
                                </div>
                                <div class="section-price-desc clearfix">
                                    <p style="text-align: center;line-height: 1.5em;min-height: 1.5em"><span class="text-shade-10-0" style="font-weight: bold">o USD 390 /año</span></p>
                                </div>
                            </div>
                            <div class="section-plan-offer">
                                <b> Incluye Plan Free </b><br>
                                <b> + </b><br>
                                Ventas ilimitadas <br>
                                Hasta 40 Mesas*<br>
                                Insumos ilimitados <br>
                                Múltiples Áreas de producción <br>
                                2 Sucursal <br>
                                Usuarios ilimitados <br>
                                MultiCajas<br>
                                Tablero de Control Basic<br>
                                3 Informes de Venta <br>
                            </div>
                            <input type="hidden" name="plan_id" value="2" />
                            
                            {{--/*
                            <button id="basic-plan-btn" onclick="window.location.replace({{\Auth::user()->plan_id==2?'':'\'upgrade/plan/2\''}})" type="button" class="btn btn-buynow {{\Auth::user()->plan_id == 2?'btn-plan-actual':''}}" style="width: 100%;">{{\Auth::user()->plan_id==2?'PLAN ACTUAL':'EMPIEZA AHORA'}}</button>
                            */--}}
                            <button id="basic-plan-btn" type="button" class="btn btn-buynow" style="width: 100%;">{{\Auth::user()->plan_id==2?'PLAN ACTUAL':'EMPIEZA AHORA'}}</button>
                        </div>
                    </div>
    
                <div class="card-pricing col-sm-4 col-md-4">
                        <div class="single-price price-one">
                            <div class="table-heading">
                                <p class="plan-name-ll">Lite</p>
                                <div class="section-plan-who clearfix">
                                    <p style="text-align: center;line-height: 1.3em;min-height: 1.3em"><span class="text-shade-7-0" style="font-size: 0.9em">Para grandes cadenas de restaurantes</span></p>
                                </div>
                                <div class="section-plan-price clearfix">
                                    <h5 style="text-align: center;line-height: 1em;min-height: 1em" ><span class="price-text" style="letter-spacing: -0.02em;font-weight: bold">USD 89.<span style="font-size:25px;vertical-align:top">90</span></span>  <span class="text-month-price" style="">/mes</span></h5>
                                </div>
                                <div class="section-price-desc clearfix">
                                    <p style="text-align: center;line-height: 1.5em;min-height: 1.5em"><span class="text-shade-10-0" style="font-weight: bold">o USD 890 /año</span></p>
                                </div>
                            </div>
                            <div class="section-plan-offer">
                                <b> Incluye Plan Basic </b><br>
                                <b> + </b><br>
                                <b>Facturación Electrónica</b><br>
                                Roles Personalizados<br>
                                Mas de 40 Mesas* <br>
                                MultiSucursal <br>
                                Tablero de Control PRO <br>
                                Gestión de Compras <br>
                                Informes de Gestión <br>
                            </div>
                            <input type="hidden" name="plan_id" value="3" />
                            <button id="lite-plan-btn" onclick="" type="button"  class="btn btn-buynow" style="width: 100%;">MUY PRONTO</button>
                        </div>
                    </div>

            </div>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="row" >
            <div class="col-md-12">
                <p style="color: white">*El número de Mesas se reparte para todas las sucursales creadas.</p>
            </div>
        </div>
    </div>
</div>

<script>
    // Create a Stripe client.
    var stripe = Stripe('pk_test_ZtnY7CopcbF55NDyytzXPB2j');

    // Create an instance of Elements.
    var elements = stripe.elements();

    // Custom styling can be passed to options when creating an Element.
    // (Note that this demo uses a wider set of styles than the guide below.)
    var style = {
        base: {
            color: '#32325d',
            lineHeight: '18px',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    };

    // Create an instance of the card Element.
    var card = elements.create('card', {style: style});
    console.log(card);
    // Add an instance of the card Element into the `card-element` <div>.
    card.mount('#card-element');

    // Handle real-time validation errors from the card Element.
    card.addEventListener('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });

    // Handle form submission.
    var form = document.getElementById('payment-form');
    form.addEventListener('submit', function(event) {
        console.log("ERES CONCHA");
        event.preventDefault();

        stripe.createToken(card).then(function(result) {
            if (result.error) {
                // Inform the user if there was an error.
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
            } else {
                // Send the token to your server.
                //stripeTokenHandler(result.token);
                var mytoken = result.token;
                console.log(mytoken);
                var form = document.getElementById('payment-form');
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', mytoken.id);
                form.appendChild(hiddenInput);

                // Submit the form
                form.submit();
            }
        });
    });

    function stripeTokenHandler(token) {
        // Insert the token ID into the form so it gets submitted to the server
        var form = document.getElementById('payment-form');
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token.id);
        form.appendChild(hiddenInput);

        // Submit the form
        form.submit();
    }
</script>

@endsection('content')