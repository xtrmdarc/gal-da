<div class="container register-form-step-plan {{ $class_active or '' }}">


    <h1 {!! Route::currentRouteName() == 'prices' ? '' : 'style="display: none;"' !!} class="title_plan">Planes</h1>

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
                        <br>1000 ventas mensuales <br>
                        1 sucursal <br>
                        Productos ilimitados <br>
                        Indicadores de control <br>
                    </div>
                    <input type="hidden" name="plan_id" value="1" />
                    <button id="free-plan-btn" onclick="window.location.replace('register')" type="button" class="btn btn-buynow" style="width: 100%;">EMPIEZA AHORA</button>
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
                            Múltiples áreas de producción <br>
                            Gestión de compras <br>
                            Informes de gestión <br>
                        </div>
                        <input type="hidden" name="plan_id" value="2" />
                        
                        <button id="basic-plan-btn" onclick="window.location.replace('register')" type="button" class="btn btn-buynow " style="width: 100%;">EMPIEZA AHORA</button>
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
                            <b> Incluye Plan Lite </b><br>
                            Facturación electrónica <br>
                            Nulla pellentesque <br>
                            Integer quis risus <br>
                            Phasellus et metus <br>
                           
                        </div>
                        <input type="hidden" name="plan_id" value="3" />
                        <button id="lite-plan-btn" onclick="window.location.replace('register')" type="button"  class="btn btn-buynow" style="width: 100%;">EMPIEZA AHORA</button>
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