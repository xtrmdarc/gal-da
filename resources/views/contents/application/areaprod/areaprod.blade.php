@extends('layouts.application.master')

@section('content')

<div class="page-wrapper">
<input type="hidden" id="id_sucursal" value="{{$id_sucursal}}"/>
<input type="hidden" id="id_areap" value="{{$id_areap}}"/>


<div class="row">
    <div class="col-md-12">
        
        {{--<div class="card nopadding panel-cocina ">
            <div class="card-body ">--}}  
                <ul class="nav nav-pills  text-center switch-cocina" style="display:block">
                    <li class=" nav-item" style="display:inline-block" > <a href="#navpills-1" class="nav-link active show" data-toggle="tab" aria-expanded="false">Pedidos</a> </li>
                    <li class="nav-item" style="display:inline-block"> <a href="#navpills-2" class="nav-link" data-toggle="tab" aria-expanded="false">Lista</a> </li>
                </ul>
        
                <div class="tab-content br-n pn">
                    <div id="navpills-1" class="tab-pane active show">
                        <div id="pedidos-container" class="row">
                            
                        </div>
                    </div>
                    <div id="navpills-2" class="tab-pane">
                                <div class="row">
                                        <div class="col-sm-3">  
                                            <div class="card">
                                                <div class="card-body">
                                                    <form id="vl_form_lista" method="post" enctype="multipart/form-data" >
                                                        <div class="form-body">
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                        <p>
                                                                            <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                                                                Más opciones +
                                                                            </a>
                                                                            {{--<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                                                                Button with data-target
                                                                            </button>--}}
                                                                        </p>
                                                                    <div class="collapse" id="collapseExample">
                                                                    
                                                                        <div class="form-group">
                                                                            <label class="control-label">Tipo</label>
                                                                            <select name="id_tipo_pedido" id="id_tipo_pedido" class="selectpicker show-tick form-control"  data-live-search="false" autocomplete="off" required="required">
                                                                                <option value="1">MESA</option>
                                                                                <option value="2">MOSTRADOR</option>
                                                                                <option value="3">DELIVERY</option>
                                                                            </select>
                                                                            <small class="form-control-feedback"> Filtro por tipo de pedido </small>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="control-label">Mozo</label>
                                                                            <select name="id_mozo" id="id_mozo" class="selectpicker show-tick form-control"  data-live-search="false" autocomplete="off" required="required">
                                                                                <option value="1">MOZ02</option>
                                                                                <option value="2">MOSTRADOR</option>
                                                                                <option value="3">DELIVERY</option>
                                                                            </select>
                                                                            <small class="form-control-feedback"> Filtro por mozo </small>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="control-label">Hora Inicio</label>
                                                                            <select name="hora_inicio" id="hora_inicio" class="selectpicker show-tick form-control"  data-live-search="false" autocomplete="off" required="required">
                                                                                <option value="1">10:20</option>
                                                                                <option value="2">MOSTRADOR</option>
                                                                                <option value="3">DELIVERY</option>
                                                                            </select>
                                                                            <small class="form-control-feedback"> Filtro desde hora inicio </small>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="control-label">Hora Fin</label>
                                                                            <select name="hora_fin" id="hora_fin" class="selectpicker show-tick form-control"  data-live-search="false" autocomplete="off" required="required">
                                                                                <option value="1">15:20</option>
                                                                                <option value="2">MOSTRADOR</option>
                                                                                <option value="3">DELIVERY</option>
                                                                            </select>
                                                                            <small class="form-control-feedback"> Filtro hasta hora fin </small>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="control-label">Estado</label>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="checkbox" value="a" name="estado_cb" id="activo_cb">
                                                                                <label class="form-check-label" for="defaultCheck1">
                                                                                    Activo
                                                                                </label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="checkbox" value="p" name="estado_cb" id="prep_cb" >
                                                                                <label class="form-check-label" for="defaultCheck2">
                                                                                    Preparacion
                                                                                </label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="checkbox" value="c" name="estado_cb" id="atendido_cb" >
                                                                                <label class="form-check-label" for="defaultCheck3">
                                                                                    Listo
                                                                                </label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="checkbox" value="i" name="estado_cb" id="cancelado_cb" >
                                                                                <label class="form-check-label" for="defaultCheck4">
                                                                                    Cancelado
                                                                                </label>
                                                                            </div>
                                                                        <small class="form-control-feedback"> Filtro hasta hora fin </small>
                                                                    </div>
                                                                    <button type="button" class="btn btn-primary" style="float:right;" onclick="privateLib.BuscarPedidosLista()"><i class="fa fa-check-square-o"></i> Consultar</button>
                                                                </div>
                                                                    
                                                            </div>
                                                        </div>
                                                    </form>
                                                    
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="col-sm-9">
                                                <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-md-12">
                                                        <div class="card ">
                                                                <div class="card-body"> 
                                                                    <div class="table-responsive m-t-0">
                                                                        <table id="vl_tabla_pedidos" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Usuario</th>
                                                                                    <th>Tipo</th>
                                                                                    <th>Cantidad</th>
                                                                                    <th>Pedido</th>
                                                                                    <th>Estado</th>
                                                                                    <th>Hora</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tfoot >
                                                                                <tr>
                                                                                    <th>Usuario</th>
                                                                                    <th>Tipo</th>
                                                                                    <th>Cantidad</th>
                                                                                    <th>Pedido</th>
                                                                                    <th>Estado</th>
                                                                                    <th>Hora</th>
                                                                                </tr>
                                                                            </tfoot>
                                                                            <tbody id="vl_tabla_body_pedidos">
                                                                                
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                </div>
                                                    
                                            </div>
                                               
                                        </div>
                                    </div>
                        </div>
                       
                    </div>
                    
                </div>
            {{--</div>
        </div>--}}
    </div>
</div>
{{--<div class="tabs-container">
    
    <ul class="nav nav-tabs right">
        <li class="active" id="tab1"><a data-toggle="tab" href="#tab-1"><i class="fa fa-cube"></i>MESA&nbsp;&nbsp;<span class="label label-primary" id="cant_pedidos_mesa"></span></a></li>
        <li id="tab2"><a data-toggle="tab" href="#tab-2"><i class="fa fa-columns"></i>MOSTRADOR&nbsp;&nbsp;<span class="label label-primary" id="cant_pedidos_most"></span></a></li>
        <li id="tab3"><a data-toggle="tab" href="#tab-3"><i class="fa fa-bicycle"></i>DELIVERY&nbsp;&nbsp;<span class="label label-primary" id="cant_pedidos_del"></span></a></li>
    </ul>
    <div class="tab-content">
        <div id="tab-1" class="tab-pane active">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <div class="panel-body">
                <div class="col-lg-12">
                    <div class="row">
                        <ul class="sortable-list connectList agile-list">
                            <li class="list-group-item lihdcm">
                                <div class="row">
                                    <div class="col-xs-1 col-md-1" style="text-align: center;">
                                        <strong>MESA</strong>
                                    </div>
                                    <div class="col-xs-4 col-md-4">
                                        <strong>CANT/PRODUCTO</strong>
                                    </div>
                                    <div class="col-xs-2 col-md-2" style="text-align: center;">
                                        <strong>HORA DE PEDIDO</strong>
                                    </div>
                                    <div class="col-xs-2 col-md-2" style="text-align: center;">
                                        <strong>ESTADO</strong>
                                    </div>
                                    <div class="col-xs-2 col-md-2">
                                        <strong>MOZO</strong>
                                    </div>
                                    <div class="col-xs-1 col-md-1"></div>
                                </div>
                            </li>
                            <div id="list_pedidos_mesa"></div>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div id="tab-2" class="tab-pane">
            <div class="panel-body">
                <div class="col-lg-12">
                    <div class="row">
                        <ul class="sortable-list connectList agile-list">
                            <li class="list-group-item lihdcmo">
                                <div class="row">
                                    <div class="col-xs-1 col-md-1" style="text-align: center;">
                                        <strong>PEDIDO</strong>
                                    </div>
                                    <div class="col-xs-4 col-md-4">
                                        <strong>CANT/PRODUCTO</strong>
                                    </div>
                                    <div class="col-xs-2 col-xs-2 col-md-2" style="text-align: center;">
                                        <strong>HORA DE PEDIDO</strong>
                                    </div>
                                    <div class="col-xs-2 col-md-2" style="text-align: center;">
                                        <strong>ESTADO</strong>
                                    </div>
                                    <div class="col-xs-2 col-md-2">
                                        <strong>CAJERO</strong>
                                    </div>
                                    <div class="col-xs-1 col-md-1"></div>
                                </div>
                            </li>
                            <div id="list_pedidos_most"></div>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div id="tab-3" class="tab-pane">
            <div class="panel-body">
                <div class="col-lg-12">
                    <div class="row">
                        <ul class="sortable-list connectList agile-list">
                            <li class="list-group-item lihdcde">
                                <div class="row">
                                    <div class="col-xs-1 col-md-1" style="text-align: center;">
                                        <strong>PEDIDO</strong>
                                    </div>
                                    <div class="col-xs-4 col-md-4">
                                        <strong>CANT/PRODUCTO</strong>
                                    </div>
                                    <div class="col-xs-2 col-md-2" style="text-align: center;">
                                        <strong>HORA DE PEDIDO</strong>
                                    </div>
                                    <div class="col-xs-2 col-md-2" style="text-align: center;">
                                        <strong>ESTADO</strong>
                                    </div>
                                    <div class="col-xs-2 col-md-2">
                                        <strong>CAJERO</strong>
                                    </div>
                                    <div class="col-xs-1 col-md-1"></div>
                                </div>
                            </li>
                            <div id="list_pedidos_del"></div>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
</div>
--}}
{{--<div class="col-sm-3" style="margin-left:5%">
        <div class="card post-it ">
            <div class="card-header post-it-header text-center">
                01: 20 m
            </div>
                
            <div class="car-body post-it-body">
                <div class="row">
                    <div class="col-sm-8">
                        <p class="card-text">Mozo: Juan Carlos</p>
                        <p class="card-text">Mesa: M02</p>
                    </div>
                    
                    <div class="col-sm-4">
                        <a class="nav-link active" href="#">Active</a>
                    </div>
                </div>  
            </div>
                

            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <div class="row"   >
                        <div class="col-sm-1 " style="height:15px;display: flex;">
                            <div class="ped-stat-sticker"></div>
                        </div>
                        <div class="col-sm-7">
                            Cebiches pequeños 
                            <div class="row">
                                <div class="col-sm-12">
                                    Sin Aji
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2"><span class="card-text"> 4m </span></div>
                        <div class="col-sm-2"><a class="btn btn-primary"  href="#">V</a></div>
                    </div>
                </li>
                <li class="list-group-item"><div class="row"   ><div class="col-sm-1 " style="height:15px;display: flex;"> <div class="ped-stat-sticker"></div> </div> <div class="col-sm-5">Cebiches pequeños </div> </div> </li>
                <li class="list-group-item"><div class="row"   ><div class="col-sm-1 " style="height:15px;display: flex;"> <div class="ped-stat-sticker"></div> </div> <div class="col-sm-5">Inka Kola</div> </div> </li>
            </ul>

        </div>
        </div>

        <div class="col-sm-3" style="margin-left:5%">
        <div class="card post-it ">
            <div class="card-header post-it-header ">
                <span class="text-left">
                    P002
                </span>
                <span style="float:right">
                    01:02 m
                </span>
            </div>
                
            <div class="car-body post-it-body">
                <div class="row">
                    <div class="col-sm-8">
                        <p class="card-text">Mozo: Juan Carlos</p>
                        <p class="card-text">Mesa: M02</p>
                    </div>
                    
                    <div class="col-sm-4">
                        <a class="nav-link active" href="#">Active</a>
                    </div>
                </div>  
            </div>
                

            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <div class="row"   >
                        <div class="col-sm-1 " style="height:15px;display: flex;">
                            <div class="ped-stat-sticker"></div>
                        </div>
                        <div class="col-sm-7">
                            Cebiches pequeños 
                            <div class="row">
                                <div class="col-sm-12">
                                    Sin Aji
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2"><span class="card-text"> 4m </span></div>
                        <div class="col-sm-2"><a class="btn btn-primary"  href="#">V</a></div>
                    </div>
                </li>
                <li class="list-group-item"><div class="row"   ><div class="col-sm-1 " style="height:15px;display: flex;"> <div class="ped-stat-sticker"></div> </div> <div class="col-sm-5">Cebiches pequeños </div> </div> </li>
                <li class="list-group-item"><div class="row"   ><div class="col-sm-1 " style="height:15px;display: flex;"> <div class="ped-stat-sticker"></div> </div> <div class="col-sm-5">Inka Kola</div> </div> </li>
            </ul>

        </div>
        </div>

        <div class="col-sm-3" style="margin-left:5%">
        <div class="card post-it ">
            <div class="card-header post-it-header ">
                <div class="row-fluid">
                    <div class="col-sm-2 text-left">
                        <span><b>M02 </b></span>
                    </div>
                    <div class="col-sm-6 text-left">
                        <span>Juan Carlos</span>
                    </div>
                    <div class="col-sm-4 text-right">
                        01: 20 m
                    </div>
                </div>

            </div>
                
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <div class="row"   >
                        <div class="col-sm-1 " style="height:15px;display: flex;">
                            <div class="ped-stat-sticker"></div>
                        </div>
                        <div class="col-sm-7">
                            Cebiches pequeños 
                            <div class="row">
                                <div class="col-sm-12">
                                    Sin Aji
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2"><span class="card-text"> 4m </span></div>
                        <div class="col-sm-2"><a class="btn btn-primary"  href="#">V</a></div>
                    </div>
                </li>
                <li class="list-group-item"><div class="row"   ><div class="col-sm-1 " style="height:15px;display: flex;"> <div class="ped-stat-sticker"></div> </div> <div class="col-sm-5">Cebiches pequeños </div> </div> </li>
                <li class="list-group-item"><div class="row"   ><div class="col-sm-1 " style="height:15px;display: flex;"> <div class="ped-stat-sticker"></div> </div> <div class="col-sm-5">Inka Kola</div> </div> </li>
            </ul>

        </div>
        </div>
        --}}
</div>
<script src="{{URL::to('js/socket.io.js') }}"></script>
<script src="{{URL::to('rest/js/plugins/buzz/buzz.min.js')}}"></script>
<script src="{{URL::to('rest/scripts/areaprod/func_areap.js')}}"></script>

<script type="text/javascript">
    $(function() {
        $('#area-p').addClass("active");
        ActualizarPedidos({!! json_encode($ordenes) !!},{!! json_encode($vl_pedidos) !!});
    });
</script>
@endsection