@extends('layouts.home.master')

@section('content')

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

                <form action="upgrade" method="post" id="payment-form" style=" margin-left: 38px; margin-right: 38px;">
                    @csrf
                    <div class="form-row">
                        <label for="card-element">
                            Credit or debit card
                        </label>
                        <div id="card-element">
                            <!-- A Stripe Element will be inserted here. -->
                        </div>

                        <!-- Used to display Element errors. -->
                        <div id="card-errors" role="alert"></div>
                    </div>

                    <button>Submit Payment</button>
                </form>
            </div>

        </div>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    var stripe = Stripe('pk_test_CtGe4ygoSnYm6Qst4ZlRWtUs');
    var elements = stripe.elements();

    // Custom styling can be passed to options when creating an Element.
    var style = {
        base: {
            // Add your base input styles here. For example:
            fontSize: '16px',
            color: "#32325d",
        }
    };

    // Create an instance of the card Element.
    var card = elements.create('card', {style: style});

    // Add an instance of the card Element into the `card-element` <div>.
    card.mount('#card-element');

    card.addEventListener('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });

    // Create a token or display an error when the form is submitted.
    var form = document.getElementById('payment-form');
    form.addEventListener('submit', function(event) {
        event.preventDefault();

        stripe.createToken(card).then(function(result) {
            if (result.error) {
                // Inform the customer that there was an error.
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
            } else {
                // Send the token to your server.
                stripeTokenHandler(result.token);
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

        console.log(token);
        // Submit the form
        form.submit();
    }

</script>

@endsection('content')