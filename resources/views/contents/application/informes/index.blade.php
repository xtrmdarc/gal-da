@extends('layouts.application.master')

@section('content')

<div class="wrapper wrapper-content animated fadeIn ">
    <div class="row">
        <div class="col-sm-6 sides_padding15">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Categor&iacute;as</h5>
                </div>
                <div class="ibox-content no-padding">
                    <div class="list-group">
                        @if(Auth::user()->plan_id == '1' || Auth::user()->plan_id == '2')
                            {{--/*PLAN FREE y LITE*/--}}
                            <a class="list-group-item ventas_free" href="#">
                                <h4 class="list-group-item-heading">Informe de Ventas</h4>
                                <p class="list-group-item-text">Informe de las ventas realizadas en el Negocio.</p>
                            </a>
                        @else
                            {{--/*PLAN BASIC*/--}}
                            <a class="list-group-item ventas" href="#">
                                <h4 class="list-group-item-heading">Informe de Ventas</h4>
                                <p class="list-group-item-text">Diversos informes de las ventas realizadas en la empresa.</p>
                            </a>

                        @endif
                        {{--/*TODO LOS PLANES*/--}}
                        <a class="list-group-item finanzas" href="#">
                            <h4 class="list-group-item-heading">Informe de Finanzas</h4>
                            <p class="list-group-item-text">Todo lo concerniente al flujo de dinero en las cajas.</p>
                        </a>
                        @if(Auth::user()->plan_id == '3')
                            {{--/*PLAN LITE*/--}}
                            <a class="list-group-item compras" href="#">
                                <h4 class="list-group-item-heading">Informe de Compras</h4>
                                <p class="list-group-item-text">Las compras que has realizado.</p>
                            </a>
                            <a class="list-group-item inventario" href="#">
                                <h4 class="list-group-item-heading">Informe de Inventario</h4>
                                <p class="list-group-item-text">Movimientos de stock generados por las ventas, compras.</p>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 " style="padding-left:15px">
            <div id="list_a">
                <div class="wrapper wrapper-content">
                    <div class="text-center">
                        <div class="row">
                            <div class="col-sm-10 block-center">
                                <br>
                                <h1 class="ich m-t-none brand-color">Módulo de Informes</h1>
                                <br>
                                <p class="ng-binding ">Navega a través de los informes para saber qué está pasando con tu negocio. <strong class="accent-color">Seleciona una categoría </strong> para ver los reportes disponibles</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      
    </div>
</div>

<script src="{{URL::to('rest/scripts/informes/func_inf.js' )}}"></script>
<script type="text/javascript">
    $('#navbar-c').addClass("white-bg");
    $('#informes').addClass("active");
</script>

@endsection('content')