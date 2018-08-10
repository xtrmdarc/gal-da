@extends('layouts.application.master')

@section('content')
<div class="page-wrapper">
@if(Auth::user()->id_rol == 4 || Auth::user()->id_rol == 5)
    <input type="hidden" id="cod_ape" value="-1"/>   
@else 
    <input type="hidden" id="cod_ape" value="{{session('id_apc')}}"/>   
@endif 
<input type="hidden" id="cod_m" value="{{session('Cod')}}"/>
<input type="hidden" id="moneda" value="{{session('moneda')}}"/>
<input type="hidden" id="id_sucursal" value="{{session('id_sucursal')}}"/>

<div class="wrapper wrapper-content animated bounce">
<div class="row">
<div class="col-lg-12 m-b-md">
    <?php if(session('rol_usr') <> 4) { ?>
    <div class="tabs-container">
        <ul class="nav nav-tabs right" role="tablist">
            <li class="nav-item "><a class="nav-link active" data-toggle="tab" href="#tabp-1"><i class="fa fa-cubes"></i>Mesas</a></li>
            <li class="nav-item" ><a class="nav-link" data-toggle="tab" href="#tabp-2"><i class="fa fa-columns"></i>Mostrador</a></li>
            <li class="nav-item" ><a class="nav-link" data-toggle="tab" href="#tabp-3"><i class="fa fa-bicycle"></i>Delivery</a></li>
        </ul>
        <div class="tab-content">
            <div id="tabp-1" class="tab-pane active"  onclick="sessionTipoPedidoMesa()">
                <div class="panel-body">
                    <div class="pull-right"></div>
    <?php } ?>
                    <div class="tabs-container">
                    <ul class="nav nav-tabs right">
                        <?php $cont=1; foreach($ListarCM as $p): ?>
                        <li id="tab<?php echo $cont++; ?>"><a data-toggle="tab" href="#tab-<?php echo $p->id_catg; ?>"><i class="fa fa-cube"></i><?php echo $p->descripcion; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="tab-content">
                        <?php $cont=1; $co=0; foreach($ListarCM as $c): ?>
                        <div id="tab-<?php echo $c->id_catg; ?>" class="tab-pane tp<?php echo $cont++; ?>">
                            <div class="panel-body">
                                <div class="row" style="text-align: center;">
                                <div class="col-sm-12">
                                    <?php foreach($ListarMesa as $r): 
                                    if ($r->id_catg == $c->id_catg AND $r->estado == 'a') { ?>
                                        {{session(['cod_tipe'=>1])}}
                                        
                                        @if(Auth::user()->id_rol != 5)
                                            <a href="#" onclick="registrarMesa(<?php echo $r->id_mesa.',\''. $r->nro_mesa.'\',\''.$r->desc_m.'\''; ?>);">
                                                <button style="width: 122px" class="btn btn-primary dim btn-large-dim" type="button"><?php echo $r->nro_mesa ?></button>
                                            </a>
                                        @else 
                                            <button style="width: 122px" class="btn btn-primary dim btn-large-dim" type="button" onclick="{{'registrarMesaCodigo('.$r->id_mesa.',\''.$r->nro_mesa.'\',\''.$r->desc_m.',\' ,\'\',\''.$r->estado.'\')'}}"><?php echo $r->nro_mesa ?></button>
                                        @endif
                                    

                                    <?php } elseif ($r->id_catg == $c->id_catg AND $r->estado == 'p') { ?>
                                        {{session(['cod_tipe'=>1])}}
                                        @if(Auth::user()->id_rol != 5)  
                                            <a href="{{'/inicio/PedidoMesa/'.$r->id_pedido}}">
                                           
                                                <button style="width: 122px" class="btn btn-info dim btn-large-dim" type="button"> <div id="{{'ind_mesa_pedidos_listos_'.$r->id_pedido}}" class="notify_pedidos_listos" style="" >{{$r->pedidos_listos}}</div>   <?php echo $r->nro_mesa ?><span class="span-b"><i class="fa fa-clock-o"></i>&nbsp;<input type="hidden" name="hora_pe[]" value="<?php echo $r->fecha_p ?>"/><span id="hora_p<?php echo $co++; ?>"><?php echo $r->fecha_p ?></span>
                                                </span></button>
                                            </a> 
                                        @else 
                                              
                                            <button style="width: 122px" class="btn btn-info dim btn-large-dim" type="button" onclick="{{'registrarMesaCodigo('.$r->id_mesa.',\''.$r->nro_mesa.'\',\''.$r->desc_m.',\' ,\''.$r->id_pedido.'\',\''.$r->estado.'\')'}}"><?php echo $r->nro_mesa ?><span class="span-b"><i class="fa fa-clock-o"></i>&nbsp;<input type="hidden" name="hora_pe[]" value="<?php echo $r->fecha_p ?>"/><span id="hora_p<?php echo $co++; ?>"><?php echo $r->fecha_p ?></span>
                                            </span></button>
                                        @endif
                                        

                                    <?php } elseif ($r->id_catg == $c->id_catg AND $r->estado == 'i') { ?>
                                        {{session(['cod_tipe'=>1])}}
                                        @if(Auth::user()->id_rol != 5)
                                            <a href="{{'/inicio/PedidoMesa/'.$r->id_pedido}}">
                                                 
                                                <button style="width: 122px" class="btn btn-danger dim btn-large-dim" type="button"><div id="{{'ind_mesa_pedidos_listos_'.$r->id_pedido}}" class="notify_pedidos_listos" style="" >{{$r->pedidos_listos}}</div>  <?php echo $r->nro_mesa ?><span class="span-b"><i class="fa fa-clock-o"></i>&nbsp;<input type="hidden" name="hora_pe[]" value="<?php echo $r->fecha_p ?>"/><span id="hora_p<?php echo $co++; ?>"><?php echo $r->fecha_p ?></span>
                                                </span></button>
                                            </a>
                                        @else 
                                            <button style="width: 122px" class="btn btn-danger dim btn-large-dim" type="button" onclick="{{'registrarMesaCodigo('.$r->id_mesa.',\''.$r->nro_mesa.'\',\''.$r->desc_m.',\' ,\''.$r->id_pedido.'\',\''.$r->estado.'\')'}}"><?php echo $r->nro_mesa ?><span class="span-b"><i class="fa fa-clock-o"></i>&nbsp;<input type="hidden" name="hora_pe[]" value="<?php echo $r->fecha_p ?>"/><span id="hora_p<?php echo $co++; ?>"><?php echo $r->fecha_p ?></span>
                                            </span></button>
                                        @endif
                                        
                                        
                                        
                                    <?php } endforeach; ?>
                                </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
    <?php if(session('rol_usr') <> 4) { ?>
                </div>
            </div>
        <div id="tabp-2" class="tab-pane" onclick="sessionTipoPedidoMostrador">
                <div class="panel-body">
                <div class="text-right">
                    <button class="btn btn-danger" data-toggle="modal" data-target="#mdl-mostrador"><i class="fa fa-location-arrow"></i>&nbsp;Nuevo Pedido</button>
                </div>
                    <ul class="sortable-list connectList agile-list">
                        <li class="list-group-item lihds">
                                <meta name="csrf-token" content="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-md-1" style="text-align: center;">
                                    <strong>PEDIDO</strong>
                                </div>
                                <div class="col-md-2" style="text-align: center;">
                                    <strong>HORA DE PEDIDO</strong>
                                </div>
                                <div class="col-md-2" style="text-align: center;">
                                    <strong>PEDIDOS LISTOS</strong>
                                </div>
                                <div class="col-md-3" style="text-align: center;">
                                    <strong>ESTADO</strong>
                                </div>
                                <div class="col-md-3">
                                    <strong>CLIENTE</strong>
                                </div>
                                <div class="col-md-1">
                                    <strong>TOTAL</strong>
                                </div>
                            </div>
                        </li>
                        <div id="list-mostrador"></div>
                    </ul>
                </div>
            </div>
            <div id="tabp-3" class="tab-pane" onclick="">
                <div class="panel-body">
                    <div class="text-right">
                        <button class="btn btn-danger" data-toggle="modal" data-target="#mdl-delivery"><i class="fa fa-location-arrow"></i>&nbsp;Nuevo Pedido</button>
                    </div>
                    <div>
                        <h3 class="text-warning"><i class="fa fa-ellipsis-h"></i>&nbsp;EN PREPARACIÓN</h3>
                    </div>
                    <ul class="sortable-list connectList agile-list">
                        <li class="list-group-item lihdo">
                            <div class="row">
                                <div class="col-md-1" style="text-align: center;">
                                    <strong>PEDIDO</strong>
                                </div>
                                <div class="col-md-2" style="text-align: center;">
                                    <strong>HORA DE PEDIDO</strong>
                                </div>
                                <div class="col-md-1" style="text-align: center;">
                                    <strong>PEDIDOS LISTOS</strong>
                                </div>
                                <div class="col-md-3">
                                    <strong>DIRECCI&Oacute;N</strong>
                                </div>
                                <div class="col-md-2">
                                    <strong>TEL&Eacute;FONO</strong>
                                </div>
                                <div class="col-md-2">
                                    <strong>CLIENTE</strong>
                                </div>
                                <div class="col-md-1">
                                    <strong>TOTAL</strong>
                                </div>
                            </div>
                        </li>
                        <div id="list-preparacion"></div>
                    </ul>
                    <hr/>
                    <div>
                        <h3 class="text-info"><i class="fa fa-arrow-right"></i>&nbsp;ENVIADOS</h3>
                    </div>
                    <ul class="sortable-list connectList agile-list">
                        <li class="list-group-item lihd">
                            <div class="row">
                                <div class="col-md-1" style="text-align: center;">
                                    <strong>PEDIDO</strong>
                                </div>
                                <div class="col-md-2" style="text-align: center;">
                                    <strong>HORA DE PEDIDO</strong>
                                </div>
                                <div class="col-md-4">
                                    <strong>DIRECCI&Oacute;N</strong>
                                </div>
                                <div class="col-md-2">
                                    <strong>TEL&Eacute;FONO</strong>
                                </div>
                                <div class="col-md-2">
                                    <strong>CLIENTE</strong>
                                </div>
                                <div class="col-md-1">
                                    <strong>TOTAL</strong>
                                </div>
                            </div>
                        </li>
                        <div id="list-enviados"></div>
                    </ul>
                </div>
            </div>
    <?php } ?>
        </div>
    </div>
</div>
</div>
</div>

<div class="modal inmodal fade" id="mdl-mesa" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content animated bounceInRight">
        <form id="frm-mesa" method="post"  class="pedido_form" enctype="multipart/form-data" action="/inicio/RegistrarMesa">
        @csrf
        <input type="hidden" name="cod_mesa" id="cod_mesa">
            <div class="modal-header">
                {{--<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>--}}
             
                <h4 class="modal-title" id="mtm"></h4>
                <small class="font-bold" id="mtp"></small>
                
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Nombre Cliente</label>
                            <input type="text" name="nomb_cliente" class="form-control" value="PUBLICO EN GENERAL" placeholder="Ingrese nombre cliente" autocomplete="off" required="required"/>
                        </div>
                    </div>  
                    <?php if(session('rol_usr') <> 4) { ?>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Nombre Mozo</label>
                            <select name="cod_mozo" id="cod_mozo" class="selectpicker show-tick form-control" data-live-search="true" autocomplete="off" title="Seleccionar Mozo" required="" data-size="5">
                            @foreach($ListarMozos as $r)
                                <option value="{{$r->id_usu}}">{{$r->nombres.' '.$r->ape_paterno.' '.$r->ape_materno}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Comentario:</label>
                            <textarea name="comentario" class="form-control" placeholder="Ingrese comentario" autocomplete="off" rows="5"> </textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary"><i class="fa fa-sign-in"></i> Abrir Mesa</button>
            </div>
        </form>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="mdl-mostrador" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content animated bounceInRight">
        <form id="frm-mostrador" method="post"  class="pedido_form" enctype="multipart/form-data" action="/inicio/RegistrarMostrador">
        @csrf
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                <h4 class="modal-title">Nuevo Pedido</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Nombre Cliente</label>
                            <input type="text" name="nomb_cliente" class="form-control" value="PUBLICO EN GENERAL" placeholder="Ingrese nombre cliente" autocomplete="off" required="required"/>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Comentario:</label>
                            <textarea name="comentario" class="form-control" placeholder="Ingrese comentario" autocomplete="off" rows="5" value=" "> </textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary"><i class="fa fa-sign-in"></i> Abrir Pedido</button>
            </div>
        </form>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="mdl-delivery" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
        <form id="frm-delivery" method="post"  class="pedido_form" enctype="multipart/form-data" action="/inicio/RegistrarDelivery">
            @csrf
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                <h4 class="modal-title">Nuevo Pedido</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 ">
                                <div class="form-group">
                                    <label class="control-label">Tel&eacute;fono</label>
                                    <div class="input-group">
                                        <input type="text" name="telefCli" id="telefCli" class="form-control global_filter" placeholder="Ingrese tel&eacute;fono" autocomplete="off" required="required"/>
                                        <span class="input-group-btn">
                                            <button id="btn_buscarCliente" class="btn btn btn-primary" type="button"> <i class="fa fa-search"></i></button>
                                        </span>
                                    </div>  
                                </div>
                            </div>
                            <div class="col-sm-6 text-center">
                                <div id='cliente_existe_loader' class="loader" style="display:none"></div>
                                <p id='cliente_existe_label' class="control-label" style="margin-top:17%">  Ingrese un número </p>
                            </div>
                        </div>      
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">Nombre Cliente</label>
                            <input type="text" name="nombCli" class="form-control" placeholder="Ingrese nombre cliente" autocomplete="off" required="required"/>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label">Apellido P.</label>
                            <input type="text" name="appCli" class="form-control" placeholder="" autocomplete="off" required="required"/>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label">Apellido M.</label>
                            <input type="text" name="apmCli" class="form-control" placeholder="" autocomplete="off" required="required"/>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Direcci&oacute;n</label>
                            <input type="text" name="direcCli" class="form-control" placeholder="Ingrese direcci&oacute;n" autocomplete="off" required="required"/>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Comentario:</label>
                            <textarea name="comentario" class="form-control" placeholder="Ingrese comentario" autocomplete="off" rows="5" text=""> </textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary"><i class="fa fa-sign-in"></i> Abrir Pedido</button>
            </div>
        </form>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="mdl-cambiar-mesa" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content animated bounceInRight">
        <form id="frm-cambiar-mesa"  method="post" enctype="multipart/form-data" action="/inicio/CambiarMesa">
            @csrf
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                <h4 class="modal-title"><i class="fa fa-exchange"></i> Cambiar Mesa</h4>
            </div>
            <div class="modal-body">     
                <div class="row">
                    <div class="col-sm-6">
                        <center><label class="control-label">Origen</label></center>
                        <div class="form-group">
                            <label class="control-label">Sal&oacute;n</label>
                            <select name="c_salon" id="cbo-salon-o" class="selectpicker show-tick form-control" data-live-search="true" autocomplete="off">
                            <?php foreach($ListarCM as $r): ?>
                                <option value="<?php echo $r->id_catg; ?>"><?php echo $r->descripcion; ?></option>
                            <?php endforeach; ?>                             
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Mesa</label>
                            <select name="c_mesa" id="c_mesa" class="selectpicker show-tick form-control" data-live-search="true" autocomplete="off" title="Seleccionar" required="required" data-size="5">                               
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6 b-l-gray-l1">
                        <center><label class="control-label">Destino</label></center>
                        <div class="form-group">
                            <label class="control-label">Sal&oacute;n</label>
                            <select name="co_salon" id="cbo-salon-d" class="selectpicker show-tick form-control" data-live-search="true" autocomplete="off">
                            <?php foreach($ListarCM as $r): ?>
                                <option value="<?php echo $r->id_catg; ?>"><?php echo $r->descripcion; ?></option>
                            <?php endforeach; ?>                                   
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Mesa</label>
                            <select name="co_mesa" id="co_mesa" class="selectpicker show-tick form-control" data-live-search="true" autocomplete="off" title="Seleccionar" required="required" data-size="5"></select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o"></i> Aceptar</button>
            </div>
        </form>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="mdl-detped" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                <h5 class="modal-title title-d" style="font-size: 18px"></h5>
            </div>
            <form method="post" enctype="multipart/form-data" action="/inicio/FinalizarPedido">
            @csrf
                <input type="hidden" name="codPed" id="codPed" value=""/>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-condensed table-striped">
                            <thead>
                                <tr>
                                    <th>Cantidad</th>
                                    <th>Producto</th>
                                    <th>P.U.</th>
                                    <th class="text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody id="lista_p"></tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-xs-3">
                            <div class="text-left">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                        <div class="col-xs-9">
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">Finalizar Pedido</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Codigo Multimozo-->
<div class="modal inmodal fade" id="mdl-codigo" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <form method="POST" class="pedido_form" enctype="multipart/form-data" action="/inicio/RegistrarMesa">
        @csrf   
        </form>
            <input type="hidden" id="nro_pedido" style="display:none;" />
            <input type="hidden" id="estadoM"  style="display:none">
            <input type="hidden" id="cod_mesa_c" style="display:none">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                <h5 class="modal-title title-d" id="mtmc"  style="font-size: 14px"></h4>
            </div>
            <div class="modal-body">
                
                <table id="digitador">
                    <tr>
                        <th colspan="3" ><input id="secret_screen" type="password"  > </th>
                    </tr>
                    <tr>
                        <td><button class="digito">7</button>  </td>
                        <td><button class="digito">8</button>  </td>
                        <td><button class="digito">9</button>  </td>
                    </tr>
                    <tr>
                        <td><button class="digito">4</button>  </td>
                        <td><button class="digito">5</button>  </td>
                        <td><button class="digito">6</button>  </td>
                    </tr>
                    <tr>
                        <td><button class="digito">1</button>  </td>
                        <td><button class="digito">2</button>  </td>
                        <td><button class="digito">3</button>  </td>
                    </tr>

                </table>

            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </form>
      </div>
    </div>
</div>

<div class="modal fade" id="mdl-validar-apertura" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-transparent text-center">
                            <i class="fa fa-warning fa-3x text-warning"></i> <h2 class="m-t-none m-b-sm">Advertencia</h2>
                            <p>Escoge la caja con la que quieres trabajar.</p>
                            <select id="cb_apc_escoger" class="form-control" style="margin-bottom:10px">
                                @foreach($aperturas as $apc)
                                    <option value="{{$apc->id_apc}}"> {{$apc->desc_caja }}</option>
                                @endforeach 
                            </select>
                            <a id="btn_escoger_apertura" class="btn btn-primary" style="width:100%;margin-bottom:20px" >Escoger</a>
                            <p>¿ No la encontraste ? Puedes aperturar una. </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-xs-3">
                        <div class="text-left">
                            <a href="/tablero" class="btn btn-default">Volver</a>
                        </div>
                    </div>
                    <div class="col-xs-9">
                        <div class="text-right">
                            <a href="caja/aper" class="btn btn-primary">Aperturar Caja</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal  fade" id="mdl-validar-limite-venta" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content animated bounceInRight">
      
            <div class="modal-header">
                <h2 class="modal-title">¡ Llegaste al límite !</h2>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-sm-12">
                        <div class="progress m-t-10">
                            <div class="progress-bar bg-danger" style="width: 100%; height:6px;" role="progressbar"> <span class="sr-only">100% Alcanzado</span> </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <p >
                            Haz alcanzado tu límite de ventas mensuales del plan <b>free</b>.  Espera
                            hasta el xx/xx/xx o <b>incrementa tu plan !</b>
                        </p>
                    </div>
                </div>
                <div class="row m-t-20">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <button type="button" class="btn btn-danger ">Esperar</button>
                        </div>
                    </div>
                    <div class="col-sm-6 ">
                        <div class="form-group">
                            <button type="button" class="btn btn-success ">Elegir plan</button>
                        </div>
                    </div>
                </div>
            </div>
            
     
        </div>
    </div>
</div>
</div>
<script src="{{URL::to('rest/scripts/inicio/func-inicio.js')}}"></script>
<script type="text/javascript">
$(function() {

    $('#restau').addClass("active");
    $('#tab1').addClass("active");
    $('.tp1').addClass("active");
    $('.scroll_content').slimscroll({
        height: '410px'
    });
});
function sessionTipoPedidoMesa(){
    {{session(['cod_tipe'=>1])}}
}  
function sessionTipoPedidoMostrador(){
    {{session(['cod_tipe'=>2])}}
} 
function sessionTipoPedidoDelivery(){
    {{session(['cod_tipe'=>3])}}
} 
</script>
@endsection