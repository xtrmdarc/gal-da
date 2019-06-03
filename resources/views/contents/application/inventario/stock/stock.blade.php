@extends('layouts.application.master')

@section('content')

    <?php
    date_default_timezone_set('America/Lima');
    setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
    $fecha = date("d-m-Y h:i A");
    $fechaa = date("-m-Y h:i A");
    ?>

    <input type="hidden" id="moneda" value="{{session('moneda_session')}}"/>

    <div class="wrapper wrapper-content animated shake">
        <div class="ibox">
            <form id="frm-excel-informe" method="post" enctype="multipart/form-data" target="_blank" action="/informesDatosIngExcel">
                @csrf
                <div class="ibox-title">
                    <div class="ibox-title-buttons pull-right">
                    </div>
                    <h5><strong><i class="fa fa-list"></i> Control de Stock</strong></h5>
                </div>
                <div class="ibox-content" style="position: relative; min-height: 30px;">
                    <div class="row">
                        {{--/*
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="sucu_filter">Almac&eacute;n</label>
                                <select name="almacen_filter" id="almacen_filter" class="selectpicker show-tick form-control" data-live-search="true" autocomplete="off" data-size="5">
                                    <option value="%" active>Todas los Almacenes</option>
                                    @foreach($almacenes as $r)
                                        <option value="{{$r->id_alm}}">{{$r->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        */--}}
                       <div class="col-sm-12">
                        <div class="form-group">
                            <label for="sucu_filter">Tipo</label>
                            <select name="tipo_p_i" id="tipo_p_i" class="selectpicker show-tick form-control" data-live-search="true" autocomplete="off" data-size="5">
                                <option value="%" active>Todos los tipos</option>
                                <option value="1">INSUMOS</option>
                                <option value="2">PRODUCTOS</option>
                            </select>
                        </div>
                    </div>
                    </div>
                    <div class="table-responsive">
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <table id="table" class="table table-hover table-condensed table-striped" width="100%">
                            <thead>
                            <tr role="row"><th rowspan="2" style="width: 47px; vertical-align: bottom; text-align: center;" class="sorting_disabled" colspan="1">Producto / Insumo</th>
                                <th rowspan="2" style="width: 133px; vertical-align: bottom; text-align: center;" class="sorting_disabled" colspan="1">Tipo</th>
                                <th rowspan="2" style="width: 133px; vertical-align: bottom; text-align: center;" class="sorting_disabled" colspan="1">Categor&iacute;a</th>
                                <th rowspan="2" style="width: 133px; vertical-align: bottom; text-align: center;" class="sorting_disabled" colspan="1">U. Medida</th>
                                <th colspan="2" style="text-align: center" class="text-danger" rowspan="1">Salida</th>
                                <th colspan="2" style="text-align: center" class="text-success" rowspan="1">Saldo</th>
                            </tr>

                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 48px; text-align: center;">Entradas</th>
                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 35px; text-align: center;">Salidas</th>
                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 35px; text-align: center;">M&iacute;nimo Requerido</th>
                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 60px; text-align: center;">Stock Total</th>
                            </th>
                            </thead>
                        </table>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="{{URL::to('rest/scripts/inventario/stock/func-stock.js' )}}"></script>
@endsection('content')