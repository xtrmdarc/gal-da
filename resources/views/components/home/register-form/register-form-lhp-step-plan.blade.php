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
                        
                        <button id="basic-plan-btn" onclick="window.location.replace('register')" type="button" class="btn btn-buynow " style="width: 100%;">EMPIEZA AHORA</button>
                    </div>
                </div>

            <div class="card-pricing col-sm-4 col-md-4">
                    <div class="single-price price-one">
                        <div class="table-heading">
                            <p class="plan-name-ll">Pro</p>
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
    <div class="col-xs-12">
        <div class="row" >
            <div class="col-md-12">
                <p style="color: white">*El número de Mesas se reparte para todas las sucursales creadas.</p>
            </div>
        </div>
    </div>
</div>