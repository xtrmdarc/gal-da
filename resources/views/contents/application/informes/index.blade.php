@extends('layouts.application.master')

@section('content')
<div class="page-wrapper">
<div class="wrapper wrapper-content animated fadeIn ">
    <div class="ibox-content m-b-sm border-bottom " style="margin-left:15px;">
        <div class="p-xs">
            <div class="pull-left m-r-md">
                <i class="fa fa-list mid-icon"></i>
            </div>
            <h2 class="m-t-none">Informes</h2> <span>Mira y analiza todos los n�meros que genera tu negocio.</span>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 sides_padding15">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Categor&iacute;as</h5>
                </div>
                <div class="ibox-content no-padding">
                    <div class="list-group">
                        @if(Auth::user()->plan_id == '1')
                            {{--/*PLAN FREE*/--}}
                            <a class="list-group-item ventas_free" href="#">
                                <h4 class="list-group-item-heading">Informe de Ventas</h4>
                                <p class="list-group-item-text">Diversos informes de las ventas realizadas en la empresa.</p>
                            </a>
                        @else
                            {{--/*PLAN LITE*/--}}
                            <a class="list-group-item ventas" href="#">
                                <h4 class="list-group-item-heading">Informe de Ventas</h4>
                                <p class="list-group-item-text">Diversos informes de las ventas realizadas en la empresa.</p>
                            </a>
                            <a class="list-group-item compras" href="#">
                                <h4 class="list-group-item-heading">Informe de Compras</h4>
                                <p class="list-group-item-text">Las compras que has realizado.</p>
                            </a>
                            <a class="list-group-item finanzas" href="#">
                                <h4 class="list-group-item-heading">Informe de Finanzas</h4>
                                <p class="list-group-item-text">Todo lo concerniente al flujo de dinero en las cajas.</p>
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
                <div class="panel panel-transparent panel-dashed text-center p-md">
                    <h2 class="m-t-none ich">Selecciona una categor&iacute;a</h2>
                    <i class="fa fa-long-arrow-left fa-3x"></i>
                    <p>Selecciona un elemento para ver los reportes disponibles.</p>
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