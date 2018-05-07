
@extends('layouts.application.master')
@section('content')
@php
    date_default_timezone_set('America/Lima');
    setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
    $fecha = date("d-m-Y h:i A");
    $fechaa = date("d-m-Y 07:00");
@endphp
<div class="page-wrapper">
<input type="hidden" id="moneda" value="{{session('moneda')}}"/>
<input type="hidden" id="dia_a" value="<?php echo $fecha; ?>"/>

<div class="wrapper wrapper-content animated fadeIn">
    <div class="row ">
            <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="col-lg-12 sides_padding15">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <div class="row">
                        <div class="col-sm-1">
                            <i class="fa fa-info-circle"></i> Datos obtenidos:
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control bg-r" name="start" id="start" value="<?php echo $fechaa,' AM'; ?>"/>
                                    <span class="input-group-addon">al</span>
                                    <input type="text" class="form-control bg-r" name="end" id="end" value="<?php echo $fecha; ?>" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ibox-content ">
                    <div class="p-w-md m-t-sm">
                        <div class="row sides_padding15">
                            <div class="col-sm-8"> 
                                <div class="row" >
                                    <div class="col-sm-4">
                                        <span class="stats-label text-navy">Ventas en efectivo</span>
                                        <h4 class="efe"></h4>
                                    </div>
                                    <div class="col-sm-4">
                                        <span class="stats-label text-success">Ventas con tarjeta</span>
                                        <h4 class="tar"></h4>
                                    </div>
                                    <div class="col-sm-4">
                                        <span class="stats-label text-info">Total de Ventas</span>
                                        <h4 class="total_v"></h4>
                                    </div>
                                    <div class="col-sm-4">
                                        <span class="stats-label text-navy">Total de ingresos de caja</span>
                                        <h4><span id="ing"></span></h4>
                                    </div>
                                    <div class="col-sm-4">
                                        <span class="stats-label text-danger">Total de egresos de caja</span>
                                        <h4><span id="gas"></span></h4>
                                    </div>
                                    <div class="col-sm-4">
                                        <span class="stats-label text-warning">Total de descuentos</span>
                                        <h4><span class="des"></span></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="row m-t-xs">
                                    <div class="col-sm-6 col-sm-offset-6">
                                        <h3 class="m-b-xs text-navy">Efectivo real</h3>
                                        <h1 class="no-margins" id="efe_real"></h1>
                                        <div class="font-bold text-navy">100% <i class="fa fa-money"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--
                <div class="ibox-content">
                    <div class="p-w-md m-t-sm">
                        <div class="row">
                            <div class="col-sm-4"> 
                                <div class="row">
                                    <div class="col-xs-4">
                                        <small class="stats-label text-navy">Ventas en efectivo</small>
                                        <h4 class="efe"></h4>
                                    </div>

                                    <div class="col-xs-4">
                                        <small class="stats-label text-success">Ventas con tarjeta</small>
                                        <h4><span class="tar"></span></h4>
                                    </div>
                                    <div class="col-xs-4">
                                        <small class="stats-label text-info">Total de Ventas</small>
                                        <h4><span class="total_v"></span></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <small class="stats-label text-danger">Total de egresos de caja</small>
                                        <h4><span id="gas"></span></h4>
                                    </div>

                                    <div class="col-xs-5">
                                        <small class="stats-label text-warning">Total de descuentos</small>
                                        <h4><span class="des"></span></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="row m-t-xs">
                                    <div class="col-xs-6">
                                        <h5 class="m-b-xs">Efectivo real</h5>
                                        <h1 class="no-margins" id="efe_real"></h1>
                                        <div class="font-bold text-navy">100% <i class="fa fa-money"></i></div>
                                    </div>
                                    <div class="col-xs-6">
                                        <h5 class="m-b-xs">Meta alcanzada</h5>
                                        <h1 class="no-margins" id="meta_a"></h1>
                                        <div class="font-bold text-navy">de 100%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div>
                                    <h1 class="m-b-xs text-navy" id="margen_d"></h1>
                                    <h4 class="font-bold no-margins">
                                        Margen de venta del día de hoy.
                                    </h4>
                                    <small>&nbsp;</small>
                                </div>
                                <div>
                                    <canvas id="lineChart" height="70"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                -->
            </div>
        </div>
    </div>
    <div class="row" >
        <div class="col-lg-3 sides_padding15">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span><i class="fa fa-money fa-2x pull-right"></i></span>
                    <h5>Ventas</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><span class="total_v"></span></h1>
                    <div class="stat-percent font-bold text-warning">Descuento <span class="des"></span> <i class="fa fa-level-down"></i></div>
                    <small>Total de ventas</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 sides_padding15">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span><i class="fa fa-paypal fa-2x pull-right"></i></span>
                    <h5>Por tipo de pago</h5>
                </div>
                <div class="ibox-content">
                <div class="row rco">
                    <div class="col-lg-6 sides_padding15">
                        <div class="font-bold text-default">Efectivo <span class="text-navy efe_p"></span></div>
                        <small><span class="efe"></span> - <span class="text-navy">100%</span></small>
                    </div>
                    <div class="col-lg-6 sides_padding15 ">
                        <div class="stat-percent font-bold text-default">Tarjeta <span class="text-navy tar_p"></span></div>
                        <small class="stat-percent"><span class="tar"></span> - <span class="text-navy">100%</span></small>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 sides_padding15">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span><i class="fa fa-line-chart fa-1x pull-right"></i></span>
                    <h5>Promedio de consumo</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins text-navy" id="pro_m"></h1>
                    <div class="stat-percent font-bold text-navy">por mesa</div>
                    <small>en <span class="t_mesas"></span> venta(s)</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 sides_padding15">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span><i class="fa fa-line-chart fa-1x pull-right"></i></span>
                    <h5>Promedio de consumo</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins text-success" id="pro_mo"></h1>
                    <div class="stat-percent font-bold text-success">para llevar</div>
                    <small>en <span class="t_most"></span> venta(s)</small>
                </div>
            </div>
        </div>
    </div>
    <div class="row ">
        <div class="col-lg-3 sides_padding15">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-primary pull-right">RANKING DIARIO</span>
                    <h5>Mozo del d&iacute;a</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins" id="mozo"></h1>
                    <div class="stat-percent font-bold text-navy"><span id="t_ped"></span>% de las ventas <i class="fa fa-level-up"></i></div>
                    <small id="pedidos"></small>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 sides_padding15">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-danger pull-right">ATENCI&Oacute;N</span>
                    <h5>Pedidos Anulados</h5>
                </div>
                <div class="ibox-content">
                    <div class="row">
                            <div class="col-md-6">
                                <h1 class="no-margins" id="pa_me"></h1>
                                <div class="font-bold text-danger">Mesas <i class="fa fa-level-down"></i></div>
                            </div>
                            <div class="col-md-6" style="text-align: right;">
                                <h1 class="no-margins" id="pa_mo"></h1>
                                <div class="font-bold text-danger">Para llevar <i class="fa fa-level-down"></i></div>
                            </div>
                        </div>

                </div>
            </div>
        </div>
        <div class="col-lg-3 sides_padding15">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-primary pull-right">DIARIO</span>
                    <h5>Mesas atendidas</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins t_mesas"></h1>
                    <div class="stat-percent font-bold text-navy">100% <i class="fa fa-bolt"></i></div>
                    <small>Mesa(s) atendida(s)</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 sides_padding15">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-success pull-right">DIARIO</span>
                    <h5>Pedidos atendidos</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins t_most"></h1>
                    <div class="stat-percent font-bold text-success">100% <i class="fa fa-bolt"></i></div>
                    <small>Pedidos(s) atendido(s)</small>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 sides_padding15">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-primary pull-right">TODOS LOS PRODUCTOS</span>
                    <h5>10 M&aacute;s vendidos</h5>
                </div>
                <div class="ibox-content">
                    <table class="table table-hover no-margins">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Producto</th>
                            <th style="text-align: center;">Ventas</th>
                            <th style="text-align: center;">Importe</th>
                            <th style="text-align: center;">% Ventas</th>
                        </tr>
                        </thead>
                        <tbody id="lista_productos">           
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6 sides_padding15">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-success pull-right">PLATOS PRINCIPALES</span>
                    <h5>10 M&aacute;s vendidos</h5>
                </div>
                <div class="ibox-content">
                    <table class="table table-hover no-margins">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Producto</th>
                            <th style="text-align: center;">Ventas</th>
                            <th style="text-align: center;">Importe</th>
                            <th style="text-align: center;">% Ventas</th>
                        </tr>
                        </thead>
                        <tbody id="lista_platos">           
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script src="{{URL::to('rest/scripts/tablero/func-tablero.js')}}"></script>


@endsection