<div class="container register-form-step-plan {{ $class_active or '' }}">


    @if(empty(\Auth::user()))
        <h1 {!! Route::currentRouteName() == 'prices' ? '' : 'style="display: none;"' !!} class="title_plan">Planes</h1>
    @else
        <h1 class="title_plan">Planes</h1>
    @endif


    <div class="price-table">
        <div class="row pricing-table" style="padding-top: 20px;">

            <div class="card-pricing col-sm-3 col-md-3">
                <div class="table-heading">
                    <p class="plan-name-ll" style="color: transparent;">1</p>
                </div>
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
                        <br>Hasta <b>500</b> Ventas Mensuales<br>
                        Hasta <b>15</b> mesas*<br>
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
                    @if(empty(\Auth::user()))
                        <button id="free-plan-btn" onclick="window.location.replace('register')" type="button" class="btn btn-buynow" style="width: 100%;">EMPIEZA AHORA</button>
                    @else
                        @if(\Auth::user()->plan_id==1 )
                            <button id="free-plan-btn" onclick="window.location.replace({{\Auth::user()->plan_id==1?'':'\'upgrade/plan/1\''}})" type="button" class="btn btn-buynow {{\Auth::user()->plan_id == 1?'btn-plan-actual':''}}" style="width: 100%;">{{\Auth::user()->plan_id==1?'PLAN ACTUAL':''}}</button>
                        @else
                            <button id="free-plan-btn" type="button" class="btn btn-buynow" style="width: 100%;">EMPIEZA AHORA</button>
                        @endif
                    @endif
                </div>
            </div>

            <div class="card-pricing col-sm-3 col-md-3">
                <div class="table-heading">
                    <p class="plan-name-ll" style="color: transparent;">2</p>
                </div>
                <div class="single-price price-one">
                    <div class="table-heading">
                        <p class="plan-name-ll">Lite</p>
                        <div class="section-plan-who clearfix">
                            <p style="text-align: center;line-height: 1.3em;min-height: 1.3em"><span class="text-shade-7-0" style="font-size: 0.9em">Para pequeños curiosos restaurantes</span></p>
                        </div>
                        <div class="section-plan-price clearfix">
                            <h5 style="text-align: center;line-height: 1em;min-height: 1em" ><span class="price-text" style="letter-spacing: -0.02em;font-weight: bold">USD 9.<span style="font-size:25px;vertical-align:top">90</span></span> <span class="text-month-price" style="">/mes</span></h5>
                        </div>
                        <div class="section-price-desc clearfix">
                            <p style="text-align: center;line-height: 1.5em;min-height: 1.5em"><span class="text-shade-10-0" style="font-weight: bold">o USD 90 /año</span></p>
                        </div>
                    </div>
                    <div class="section-plan-offer">
                        <br>Hasta <b>1100</b> Ventas Mensuales <br>
                        Hasta <b>20</b> mesas*<br>
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
                    <input type="hidden" name="plan_id" value="2" />
                    @if(empty(\Auth::user()))
                            <button id="lite-plan-btn" onclick="window.location.replace('register')" type="button" class="btn btn-buynow" style="width: 100%;">EMPIEZA AHORA</button>
                    @else
                        @if(\Auth::user()->plan_id==2 )
                            <button id="lite-plan-btn" onclick="window.location.replace({{\Auth::user()->plan_id==2?'':'\'upgrade/plan/2\''}})" type="button" class="btn btn-buynow {{\Auth::user()->plan_id == 2?'btn-plan-actual':''}}" style="width: 100%;">{{\Auth::user()->plan_id==2?'PLAN ACTUAL':''}}</button>
                        @else
                            <button id="lite-plan-btn" type="button" class="btn btn-buynow" style="width: 100%;">EMPIEZA AHORA</button>
                        @endif
                    @endif
                </div>
            </div>

            <div class="card-pricing col-sm-3 col-md-3">
                <div class="table-heading recomend-plan">
                    <p class="plan-name-ll recomend-plan-p">RECOMENDADO</p>
                </div>
                    <div class="single-price price-one" style="border-radius: 0px 0px 5px 5px;border: solid;border-color: black;">
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
                            <b> Incluye Plan Lite </b><br>
                            <b> + </b><br>
                            Ventas ilimitadas <br>
                            Hasta <b>40</b> Mesas*<br>
                            Insumos ilimitados <br>
                            Múltiples Áreas de producción <br>
                            2 Sucursal <br>
                            Usuarios ilimitados <br>
                            MultiCajas<br>
                            Tablero de Control Basic<br>
                            3 Informes de Venta <br>
                        </div>
                        <input type="hidden" name="plan_id" value="3" />
                        @if(empty(\Auth::user()))
                            <button id="basic-plan-btn" onclick="window.location.replace('register')" type="button" class="btn btn-buynow" style="width: 100%;">EMPIEZA AHORA</button>
                        @else
                            @if(\Auth::user()->plan_id==3 )
                                <button id="basic-plan-btn" onclick="window.location.replace({{\Auth::user()->plan_id==3?'':'\'upgrade/plan/3\''}})" type="button" class="btn btn-buynow {{\Auth::user()->plan_id == 3?'btn-plan-actual':''}}" style="width: 100%;">{{\Auth::user()->plan_id==3?'PLAN ACTUAL':''}}</button>
                            @else
                                <button id="basic-plan-btn" type="button" class="btn btn-buynow" style="width: 100%;">EMPIEZA AHORA</button>
                            @endif
                        @endif
                    </div>
                </div>

            <div class="card-pricing col-sm-3 col-md-3">
                <div class="table-heading">
                    <p class="plan-name-ll" style="color: transparent;">4</p>
                </div>
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
                            Gestión de Inventario (Kardex) <br>
                            Gestión de Recetas <br>
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