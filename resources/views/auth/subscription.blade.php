@extends('layouts.home.master')

@section('content')
@php
/*
<div class="background-gray-auth">

    <h1 class="title_plan">Seleccion tu Plan UPGRADE</h1>

    <div class="price-table">
        <div class="row pricing-table">

            <div class="card-pricing col-sm-6 col-md-4">
                <div class="single-price price-one">
                    <div class="table-heading">
                        <p class="plan-name">Free Plan</p>
                        <p class="plan-price"><span class="dollar-sign">$</span><span class="price">0</span><span class="month">/ for ever</span></p>
                    </div>
                    <ul>
                        <li>Lorem ipsum dolor <span><i class="fa fa-check"></i></span></li>
                        <li>Consectetur adipiscing <span><i class="fa fa-times"></i></span></li>
                        <li>Nulla pellentesque <span><i class="fa fa-times"></i></span> </li>
                        <li> Integer quis risus <span><i class="fa fa-check"></i></span></li>
                        <li>Phasellus et metus <span><i class="fa fa-times"></i></span></li>
                        <li>Duis nec massa inter <span><i class="fa fa-check"></i></span></li>
                    </ul>
                    <input type="hidden" name="plan_id" value="1" />
                    @if(Auth::user()->plan_id == '1')
                        <button id="btn-register-payment-free" type="button" class="btn btn-buynow" style="width: 100%; " disabled>Current Plan</button>
                    @else
                        <button id="btn-register-payment-free" type="button" class="btn btn-buynow" style="width: 100%;">Buy Now</button>
                    @endif
                </div>
            </div>

            <div>
                <form method="POST" action="">
                    {{ csrf_field() }}
                    <div class="card-pricing col-sm-6 col-md-4">
                        <div class="single-price price-two">
                            <div class="table-heading">
                                <p class="plan-name">Lite Plan</p>
                                <p class="plan-price"><span class="dollar-sign">$</span><span class="price">80</span><span class="month">/ Month</span></p>
                            </div>
                            <ul>
                                <li>Lorem ipsum dolor <span><i class="fa fa-check"></i></span></li>
                                <li>Consectetur adipiscing <span><i class="fa fa-times"></i></span></li>
                                <li>Nulla pellentesque <span><i class="fa fa-times"></i></span> </li>
                                <li> Integer quis risus <span><i class="fa fa-check"></i></span></li>
                                <li>Phasellus et metus <span><i class="fa fa-times"></i></span></li>
                                <li>Duis nec massa inter <span><i class="fa fa-check"></i></span></li>
                            </ul>
                            <input type="hidden" name="plan-id" value="2" />

                            @if(Auth::user()->plan_id == '2')
                                <button type="submit" class="btn btn-buynow" style="width: 100%;" disabled>Current Plan</button>
                            @else
                                <button type="submit" class="btn btn-buynow" style="width: 100%;">Buy Now</button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>

            <div>
                <form method="POST" action="">
                    {{ csrf_field() }}
                    <div class="card-pricing col-sm-6 col-md-4">
                        <div class="single-price price-three">
                            <div class="table-heading">
                                <p class="plan-name">Gold Plan</p>
                                <p class="plan-price"><span class="dollar-sign">$</span><span class="price">80</span><span class="month">/ Month</span></p>
                            </div>
                            <ul>
                                <li>Lorem ipsum dolor <span><i class="fa fa-check"></i></span></li>
                                <li>Consectetur adipiscing <span><i class="fa fa-times"></i></span></li>
                                <li>Nulla pellentesque <span><i class="fa fa-times"></i></span> </li>
                                <li> Integer quis risus <span><i class="fa fa-check"></i></span></li>
                                <li>Phasellus et metus <span><i class="fa fa-times"></i></span></li>
                                <li>Duis nec massa inter <span><i class="fa fa-check"></i></span></li>
                            </ul>
                            <input type="hidden" name="plan-id" value="3" />

                            @if(Auth::user()->plan_id == '3')
                                <button type="submit" class="btn btn-buynow" style="width: 100%;" disabled>Current Plan</button>
                            @else
                                <button type="submit" class="btn btn-buynow" style="width: 100%;">Buy Now</button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>

            <h1 class="title_plan">Select your payment schedule</h1>

            <div class="page-wrapper">
                <div class="wrapper wrapper-content animated shake">
                    <div class="ibox">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card p-30" style="background: #ffffff none repeat scroll 0 0;
                                margin: 15px 0;
                                padding: 20px;
                                border: 0 solid #e7e7e7;
                                border-radius: 5px;
                                margin-left: 38px;
                                box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);">
                                    <div class="media">
                                        <div class="media-left meida media-middle">
                                            <span><i class="fa fa-usd f-s-40 color-primary"></i></span>
                                        </div>
                                        <div class="media-body media-text-right">
                                            <p class="m-b-0">Mensual</p>
                                            <h2 id="totalVentasI">79.99</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card p-30" style="background: #ffffff none repeat scroll 0 0;
                                margin: 15px 0;
                                padding: 20px;
                                border: 0 solid #e7e7e7;
                                border-radius: 5px;
                                margin-right: 38px;
                                box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);">
                                    <div class="media">
                                        <div class="media-left meida media-middle">
                                            <span><i class="fa fa-usd f-s-40 color-success"></i></span>
                                        </div>
                                        <div class="media-body media-text-right">
                                            <p class="m-b-0">Anual</p>
                                            <h2 id="nVentasI">790.99</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <form action="/upgrade" method="post" id="payment-form" style=" margin-left: 38px; margin-right: 38px;">
                    @csrf
                    <div class="form-group">
                        <label for="card-element">Credit Card</label>
                        <div id="card-element">
                            <!-- a Stripe Element will be inserted here. -->
                        </div>

                        <!-- Used to display form errors -->
                        <div id="card-errors" role="alert"></div>
                    </div>

                    <div class="spacer"></div>

                    <button type="submit" class="btn btn-success">Submit Payment</button>

                </form>

                <form action="/upgrade" method="POST">
                    {{csrf_field()}}

                    <input type="text" name="coupon">

                    <script
                            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                            data-key="pk_test_ZtnY7CopcbF55NDyytzXPB2j"
                            data-amount="1100"
                            data-name="Webcasts"
                            data-description="Subscribe to Awesome Blogs"
                            data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                            data-label="Subscribe Now"
                            data-email="{{ auth()->check()?auth()->user()->email: null}}"
                            data-panel-label="Pay Monthly"
                            data-locale="auto">
                    </script>
                </form>
            </div>

        </div>
    </div>
</div>
*/
@endphp
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
                            Hasta 15 mesas <br>
                            Productos Ilimitados <br>
                            1 Área de Producción <br>
                            1 Sucursal <br>
                            5 Usuarios <br>
                            1 caja <br>
                            Tablero de Control <br>
                            *Clientes <br>
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
                                    <h5 style="text-align: center;line-height: 1em;min-height: 1em" ><span class="price-text" style="letter-spacing: -0.02em;font-weight: bold">$39.<span style="font-size:25px;vertical-align:top">99</span></span> <span class="text-month-price" style="">/mes</span></h5>
                                </div>
                                <div class="section-price-desc clearfix">
                                    <p style="text-align: center;line-height: 1.5em;min-height: 1.5em"><span class="text-shade-10-0" style="font-weight: bold">o $390 /año</span></p>
                                </div>
                            </div>
                            <div class="section-plan-offer">
                                <b> Incluye Plan Free </b><br>
                                Ventas ilimitadas <br>
                                Usuarios ilimitadas <br>
                                Hasta 40 Mesas <br>
                                2 Sucursal <br>
                                MultiCajas<br>
                                Múltiples Áreas de producción <br>
                                1 Informe de Venta <br>
                            </div>
                            <input type="hidden" name="plan_id" value="2" />
                            
                            <button id="basic-plan-btn" onclick="window.location.replace({{\Auth::user()->plan_id==2?'':'\'upgrade/plan/2\''}})" type="button" class="btn btn-buynow {{\Auth::user()->plan_id == 2?'btn-plan-actual':''}}" style="width: 100%;">{{\Auth::user()->plan_id==2?'PLAN ACTUAL':'EMPIEZA AHORA'}}</button>
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
                                    <h5 style="text-align: center;line-height: 1em;min-height: 1em" ><span class="price-text" style="letter-spacing: -0.02em;font-weight: bold">$89.<span style="font-size:25px;vertical-align:top">99</span></span>  <span class="text-month-price" style="">/mes</span></h5>
                                </div>
                                <div class="section-price-desc clearfix">
                                    <p style="text-align: center;line-height: 1.5em;min-height: 1.5em"><span class="text-shade-10-0" style="font-weight: bold">o $890 /año</span></p>
                                </div>
                            </div>
                            <div class="section-plan-offer">
                                <b> Incluye Plan Basic </b><br>
                                Usuarios Avanzandos <br>
                                Mas de 40 Mesas <br>
                                MultiSucursal <br>
                                Tablero de Control Lite <br>
                                Gestión de Crédito <br>
                                Gestión de Compras <br>
                                Insumos ilimitados <br>
                                Informes de Gestión <br>
                               
                            </div>
                            <input type="hidden" name="plan_id" value="3" />
                            <button id="lite-plan-btn" onclick="" type="button"  class="btn btn-buynow" style="width: 100%;">MUY PRONTO</button>
                        </div>
                    </div>
    
                <div style="display: none">
                    <form method="POST" action="">
                        {{ csrf_field() }}
                        <div class="card-pricing col-sm-6 col-md-6">
                            <div class="single-price price-two">
                                <div class="table-heading">
                                    <p class="plan-name">Lite Plan</p>
                                    <p class="plan-price"><span class="dollar-sign">$</span><span class="price">80</span><span class="month">/ Month</span></p>
                                    
                                </div>
                                <ul>
                                    <li>Lorem ipsum dolor <span><i class="fa fa-check"></i></span></li>
                                    <li>Consectetur adipiscing <span><i class="fa fa-times"></i></span></li>
                                    <li>Nulla pellentesque <span><i class="fa fa-times"></i></span> </li>
                                    <li> Integer quis risus <span><i class="fa fa-check"></i></span></li>
                                    <li>Phasellus et metus <span><i class="fa fa-times"></i></span></li>
                                    <li>Duis nec massa inter <span><i class="fa fa-check"></i></span></li>
                                </ul>
                                <input type="hidden" name="plan-id" value="2" />
                                <button type="submit" class="btn btn-buynow" style="width: 100%;">Buy Now</button>
                            </div>
                        </div>
                    </form>
                </div>
    
    
                {{--/*<div class="col-sm-6 col-md-3">
                    <div class="single-price price-three">
                        <div class="table-heading">
                            <p class="plan-name">Glod Plan</p>
                            <p class="plan-price"><span class="dollar-sign">$</span><span class="price">29</span><span class="month">/ Month</span></p>
                        </div>
                        <ul>
                            <li>Lorem ipsum dolor <span><i class="fa fa-check"></i></span></li>
                            <li>Consectetur adipiscing <span><i class="fa fa-times"></i></span></li>
                            <li>Nulla pellentesque <span><i class="fa fa-times"></i></span> </li>
                            <li> Integer quis risus <span><i class="fa fa-check"></i></span></li>
                            <li>Phasellus et metus <span><i class="fa fa-times"></i></span></li>
                            <li>Duis nec massa inter <span><i class="fa fa-check"></i></span></li>
                        </ul>
                        <a href="#" class="btn btn-buynow">Buy Now</a>
                    </div>
                </div>*/--}}
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