<!-Payment Info->
<div class="background-gray-auth register-form-step-payment {{ $class_active or '' }}">
    <div class="unix-login">
        <div class="container-fluid-auth">
            <div class="row justify-content-center-auth">
                <div class="col-lg-4 card-center">
                    <div class="auth-content card-auth">
                        <div class="login-form-auth">
                            <h4>Payment Info</h4>
                            <div style="display: none">
                                <h5>Ingrese su tarjeta de credito o debito</h5>
                                <script src="https://js.stripe.com/v3/"></script>


                                <div class="form-row">
                                    <label for="card-element">
                                        Credit or debit card
                                    </label>
                                    <div id="card-element">
                                        <!-- A Stripe Element will be inserted here. -->
                                    </div>

                                    <!-- Used to display form errors. -->
                                    <div id="card-errors" role="alert"></div>
                                </div>
                            </div>

                            <div id="accordion-container">
                                <h2 class="page-header">Tu plan</h2>
                                <div class="panel-group" id="accordion">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                                    Free
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseOne" class="panel-collapse collapse in">
                                            <div class="panel-body">
                                                Plan Free - <b><h5>0$</h5></b>, incluye full control. <a href="">Cambiar</a>
                                            </div>
                                            <div class="panel-body">
                                                Los pagos se procesaran internacionalmente. Es posible que se apliquen comisiones bancarias adicionales.

                                                <br><br>GAL-DA  continuara tu membresia de manera automatica cada mes y te facturara el cargo mensual (actualmente de 80$) a traves de la forma de pago elegida hasta que la canceles. No se ofrecen reembolsos ni creditos por meses parciales.
                                            </div>
                                        </div>
                                    </div>
                                </div><!--/#accordion-->
                            </div><!--/#accordion-container-->

                            <button id="btn-register-payment-all" class="btn btn-primary btn-flat m-b-30 m-t-30">Pagar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>