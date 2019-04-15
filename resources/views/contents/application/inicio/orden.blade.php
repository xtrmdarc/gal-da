@extends('layouts.application.master')

@section('content')


<input type="hidden" id="moneda" value="{{session('moneda_session')}}"/>
<input type="hidden" id="cod_m" value="<?php //echo $_GET['m']; ?>"/>
<input type="hidden" id="cod_p" value="{{$cod}}"/>
<input type="hidden" id="index" value="{{$index}}"/>
<input type="hidden" id="cod_tipe" value="{{session('cod_tipe')}} "/>
<input type="hidden" id="rol_usr" value="{{session('rol_usr')}} "/>


    <div class="row">
        <div class="col-lg-5" style="display:inline-block; padding-right:0px" >
            <div class="mail-box-header title-pink">
                <div class="row">
                    <div class="col-sm-2" style="margin-bottom:7px;margin-top:-10px">
                        <button class="btn btn-accent" onclick="window.location.replace('/inicio')">  <i class="fa fa-arrow-left"  style="width:20px;color:white;"></i></button>
                    </div>
                    
                </div>
                <div class="pull-right mail-search btn-imp"></div>
                
                <h2><i id="ico-ped"></i> <span class="mes_dg"></span></h2>
            </div>
            <div class="mail-box-header border-top" style="border-top: 1px solid #c4c4c4;">
                <div class="row">
                    <div class="col-sm-8">
                        <p>Cliente: <strong class="cli_dg"></strong> - <i class="fa fa-calendar"></i> <span class="fec_dg"></span> <i class="fa fa-clock-o"></i> <span class="hor_dg"></span></p>
                    </div>
                    <div class="col-sm-4 text-right bc" style="display: none; margin-top: -5px;">
                        <input type="hidden" name="cod_p" id="cod_p" value="{{$cod}}" />
                        <button class="btn btn-md btn-primary animated wobble" id="btn-confirmar"><i class="fa fa-location-arrow"></i>&nbsp;CONFIRMAR</button>
                    </div>
                </div>
            </div>
            <div class="mail-box scroll_izq">
                <ul id="pedido-detalle" class="sortable-list agile-list" style="display: none;"></ul>
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <table class="table table-hover table-mail" id="table-pedidos" style="margin-bottom: 0px;" width="100%">
                    <thead class="li-c">
                        <tr>
                            <td class="check-mail li-c">Cant.</td>
                            <td class="mail-contact">Producto</td>
                            <td class="text-right mail-date">P.U.</td>
                            <td class="text-right mail-date">Total</td>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="mail-box" style="padding: 10px; background: #fcfcfc">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="descriptive-icon text-left">
                            <span class="icon"><i class="fa fa-money fa-2x"></i></span>
                            <div class="text">
                                <span id="totalPagar"></span><span> por pagar</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                    @if(session('rol_usr') <> 4) 
                        <div class="text-right opc1" style="display: none">
                            @if(\Auth::user()->id_rol != 4 &&  \Auth::user()->id_rol != 5 )
                                @if(session('cod_tipe')!=3)
                                <button type="button" class="btn btn-success" onclick="facturar({{$cod}},2);"><i class="fa fa-files-o"></i>&nbsp;Dividir Cuenta</button>
                                @endif
                                <button type="button" class="btn btn-lg btn-primary" onclick="facturar({{$cod}},1);"><i class="fa fa-file-o"></i>&nbsp;Cuenta</button>
                            @endif
                        </div>
                    @endif 
                        <div class="text-right opc2" style="display: none">
                            <button type="button" class="btn btn-danger" onclick="desocuparMesa({{$cod}});"><i class="fa fa-sign-out"></i>&nbsp;Desocupar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-7 border-left" style="padding: 0px !important;display:inline-block;float:right;">
            <div class="ibox-content" style="background: #e5e5e5;  border-bottom: 1px solid #72be98;">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="has-success">
                        <div class="input-group">
                            <input type="text" name="busq_prod" id="busq_prod" class="form-control ui-autocomplete-input" placeholder="Buscar producto..." autocomplete="off">
                            <button class="btn btn btn-primary"> <i class="fa fa-search"></i></button>
                        </div>
                        </div>
                    </div>
                </div>  
            </div>
            <ul class="nav nav-tabs catg" id="list-catgrs"></ul>
            <div class="tab-content" style="padding: 8px !important">
                <div id="tab-1" class="tab-pane active">
                    <div class="row1 scroll_der" id="list-prods">
                        <div class="wrapper wrapper-content">
                            <div class="text-center">
                                <div class="block-center">
                                    <br>
                                    <h2 class="ich m-t-none accent-color">Selecciona una categoría</h2>
                                    <br>
                                    <p class="ng-binding col-sm-8 block-center" >Escoge una de tus categorías para listar los productos!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal inmodal fade" id="mdl-facturar" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <form id="frm-facturar" method="post" enctype="multipart/form-data" class="frm-facturar unif_modal" >
            @csrf
            <input type="hidden" name="cod_pedido" id="cod_pedido">
            <input type="hidden" name="tipoEmision" id="tipoEmision">
            <input type="hidden" name="totalPed" id="totalPed">
            <input type="hidden" name="total_pedido" id="total_pedido">
                <div class="modal-header mh" id="hhb">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                    <h4 class="modal-title mt"><strong>CERRAR MESA</strong></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="sortable-list connectList agile-list">
                                <li class="list-group-item lihds">
                                    <strong>LISTA DE PEDIDOS:</strong>
                                </li>
                                <div class="scroll_content" id="list-items"></div>
                                <li class="warning-element lisbt" id="sbt" style="display: none;">
                                    <div class="row">
                                        <div class="col-xs-9 col-sm-9 col-md-9">
                                            <strong>SubTotal</strong>
                                        </div>
                                        <div class="col-xs-3 col-sm-3 col-md-3">
                                            <div class="text-right">
                                                <strong> {{session('moneda_session')}} <span id="t_sbt">0.00</span></strong>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="warning-element lides" id="desc" style="display: none;">
                                    <div class="row">
                                        <div class="col-xs-3 col-sm-3">
                                            <div class="text-left">
                                                <span class="form-control txtlbl" style="background: none; border:none;">Descuento</span>
                                            </div>
                                        </div>
                                        <div class="col-xs-4 col-sm-4">
                                            <div class="text-left">
                                                <div class="has-warning">
                                                    <div class="input-group ent">
                                                        <input type="text" name="porcentaje" id="porcentaje" class="form-control" placeholder="" autocomplete="off" />
                                                        <span class="input-group-addon">%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-5 col-sm-5">
                                            <div class="text-right">
                                                <div class="has-warning">
                                                    <div class="input-group dec">
                                                        <span class="input-group-addon">{{session('moneda_session')}}</span>
                                                        <input type="text" name="m_desc" id="m_desc" class="form-control" placeholder="" autocomplete="off" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="sortable-list connectList agile-list">
                                <li class="list-group-item lihds">
                                    <strong>PAGO:</strong>
                                </li>
                            </ul>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Tipo Pago</label>
                                        <select name="tipo_pago" id="tipo_pago" class="selectpicker show-tick form-control" data-live-search-style="begins" data-live-search="true" title="Seleccionar" autocomplete="off">
                                            <option value="1">EFECTIVO</option>
                                            <option value="2">TARJETA</option>
                                            <option value="3">AMBOS</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Tipo Documento</label>
                                        <select name="tipo_doc" id="tipo_doc" class="selectpicker show-tick form-control" data-live-search-style="begins" data-live-search="true" title="Seleccionar" autocomplete="off">
                                            @foreach($Comprobantes as $r)
                                                <option value="{{$r->id_tipo_doc}}">{{$r->descripcion}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                           
                            
                            <div class="row">
                                        
                                <div class="col-sm-6" id="pe" style="display: none;">
                                    <label >Monto</label>
                                    <div class="form-group">
                                        <div class="input-group dec">
                                            <span class="input-group-addon" style="line-height: normal;">{{session('moneda_session')}}</span>
                                            <input type="text" name="pago_e" id="pago_e" class="form-control" placeholder="Efectivo" autocomplete="off" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6" id="pt" style="display: none;">
                                    <label >Monto</label>
                                    <div class="form-group">
                                        <div class="input-group dec">
                                            <span class="input-group-addon" style="line-height: normal;">{{session('moneda_session')}}</span>
                                            <input type="text" name="pago_t" id="pago_t" class="form-control" placeholder="Tarjeta" autocomplete="off" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Cliente</label>
                                        <div class="input-group">
                                            <button type="button" class="btn btn-primary" onclick="nuevoCliente();"><i class="fa fa-plus"></i></button>
                                            <input type="hidden" name="cliente_id" id="cliente_id" value="1"/>
                                            <input type="text" name="busq_cli" id="busq_cli" class="form-control" placeholder="Ingrese DNI/RUC del cliente" autocomplete="off" />
                                            <button id="btnClienteLimpiar" class="btn btn-danger" type="button">
                                                <span class="fa fa-remove"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <input type="text" name="nombre_c" id="nombre_c" class="form-control" autocomplete="off" value="P&Uacute;BLICO GENERAL" disabled/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <ul class="sortable-list agile-list">
                                <li class="litot-i">
                                    <div class="row">
                                        <div class="col-xs-9 col-sm-9 col-md-9">
                                            <strong>TOTAL</strong>
                                        </div>
                                        <div class="col-xs-3 col-sm-3 col-md-3">
                                            <div class="text-right">
                                                <strong>{{session('moneda_session')}}<span class="totalP" id="total"></span></strong>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-sm-6">
                            <ul class="sortable-list agile-list">
                                <li class="litot-d">
                                    <div class="row">
                                        <div class="col-xs-9 col-sm-9 col-md-9">
                                            <strong>VUELTO</strong>
                                        </div>
                                        <div class="col-xs-3 col-sm-3 col-md-3">
                                            <div class="text-right">
                                                <strong>{{session('moneda_session')}}<span id="vuelto">0.00</span></strong>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row" style="width:100%">
                        <div class="col-xs-6 col-sm-6">
                            <div class="text-left">
                                <a href="#" class="btn btn-info" onclick="porcentajeTotal();">Descuento %</a>
                            </div>
                        </div>

                        <div class="col-xs-6 col-sm-6" style="float:right;" >
                            <button type="submit" class="btn btn-primary" id="btn-fact" style="float:right;"><i class="fa fa-save"></i> Aceptar</button>
                            <button type="button" class="btn btn-white" data-dismiss="modal" style="float:right;">Volver</button>
                        </div>
                                


                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>

    <div class="modal inmodal fade" id="mdl-nuevo-cliente" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="true">
        <div class="modal-dialog">
            <div class="modal-content animated bounceInTop unif_modal">
                <div class="modal-header mhs-e">
                    <h4 class="modal-title">Nuevo Cliente</h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input name="tipo_docc" type="radio" value="1" id="td_dni" class="flat-red" checked="true"> DNI
                                    &nbsp;
                                <input name="tipo_docc" type="radio" value="2" id="td_ruc" class="flat-red"> RUC
                            </div>
                        </div>
                        @if(session('datosempresa')->id_pais == 'PE')
                        <div class="col-lg-6" id="f_dni" style="display: block;">
                            <form method="post" id="form_consultadni">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" name="dni_numero" id="dni_numero" class="form-control validanumericos" placeholder="Ingrese DNI" autocomplete="off" />
                                        <button id="btnBuscar" class="btn btn-primary" type="submit"><span class="fa fa-search"></span></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-6" id="f_ruc" style="display: none;">
                            <form method="post" id="form_consultaruc">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group">
                                            <input type="text" name="ruc_numero" id="ruc_numero" class="form-control validanumericos" placeholder="Ingrese RUC" autocomplete="off" />
                                            <button id="btnBuscar" class="btn btn-primary" type="submit"><span class="fa fa-search"></span></button>
                                        </span>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @endif
                    </div>
                    <form method="post" id="form_c">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div  id="div_ruc" class="col-lg-6" id="d_ruc" style="display: none;">
                                    <div class="form-group">
                                        <label>RUC</label>
                                        <input type="text" name="ruc" id="ruc"  maxlength="20" class="form-control" placeholder="Ingrese ruc" autocomplete="off" />
                                    </div>
                                </div>
                                <div id="div_dni" class="col-lg-6" style="display:none">
                                    <div class="form-group">
                                        <label>DNI</label>
                                        <input type="text" name="dni" id="dni" maxlength="15" class="form-control" placeholder="Ingrese dni" autocomplete="off"/>
                                    </div>
                                </div>
                                <div class="col-lg-6" id="d_nombres" style="display: block;">
                                    <div class="form-group">
                                        <label>Nombres</label>
                                        <input type="text" name="nombres" id="nombres" class="form-control" placeholder="Ingrese nombres" autocomplete="off"/>
                                    </div>
                                </div>
                                <div class="col-lg-6" id="d_apep" style="display: block;">
                                    <div class="form-group">
                                        <label>Apellido Paterno</label>
                                        <input type="text" name="ape_paterno" id="ape_paterno" class="form-control" placeholder="Ingrese apellido paterno" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="col-lg-6" id="d_apem" style="display: block;">
                                    <div class="form-group">
                                        <label>Apellido Materno</label>
                                        <input type="text" name="ape_materno" id="ape_materno" class="form-control" placeholder="Ingrese apellido materno" autocomplete="off" />
                                    </div>
                                </div>
                                {{-- <div class="col-lg-6" id="d_fecha" style="display: none;">
                                    <div class="form-group">
                                        <label>Fecha de Nacimiento</label>
                                        <input type="text" name="fecha_nac" id="fecha_nac" data-mask="99-99-9999" class="form-control" placeholder="Ingrese fecha de nacimiento" autocomplete="off" />
                                    </div>
                                </div> --}}
                                <div class="col-lg-12" id="d_telefono" style="display: block;">
                                    <div class="form-group">
                                        <label>Tel&eacute;fono</label>
                                        <input type="text" name="telefono" id="telefono" data-mask="999999999" class="form-control" placeholder="Ingrese tel&eacute;fono" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="col-lg-12" id="d_correo" style="display: block;">
                                    <div class="form-group">
                                        <label>Correo electr&oacute;nico</label>
                                        <input type="text" name="correo" id="correo" class="form-control" placeholder="Ingrese correo electr&oacute;nico" autocomplete="off" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="d_rs" style="display: none;">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Raz&oacute;n Social</label>
                                <input type="text" name="razon_social" id="razon_social" class="form-control" placeholder="Ingrese raz&oacute;n social" autocomplete="off" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Direcci&oacute;n</label>
                                <input type="text" name="direccion" id="direccion" class="form-control" placeholder="Ingrese direcci&oacute;n" autocomplete="off" />
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Volver</button>
                    <button type="button" class="btn btn-primary" id="RegistrarCliente"><i class="fa fa-save"></i> Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal inmodal fade" id="mdl-sub-pedido" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content animated bounceInRight">
            <form method="post" enctype="multipart/form-data" action="#" class="unif_modal">
                <div class="modal-header mh-e">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                    <h4 class="modal-title mt"><strong id="title-caja">Detalle por orden de pedido</strong></h4>
                </div>
                <div class="modal-body">
                    <ul class="sortable-list agile-list">
                        <li class="list-group-item li-c">
                            <div class="row">
                                <div class="col-xs-1 col-sm-1 col-md-1"><strong>Cant.</strong></div>
                                <div class="col-xs-5 col-sm-6 col-md-6"><strong>Producto</strong></div>
                                <div class="col-xs-4 col-sm-4 col-md-4"><strong>P.U. / Total</strong></div>
                                <div class="col-xs-1 col-sm-1 col-md-1"></div>
                            </div>  
                        </li>
                        <div class="scroll_content" id="list-subitems"></div>
                    </ul>
                </div>
                <div class="modal-footer" style="display:block">
                    <div style="float:left">
                        <span class="label label-primary">En Espera</span>
                        <span class="label label-warning">Preparando</span>
                        <span class="label label-success">Listo</span>
                    </div>

                    <button type="button" style="float:right" class="btn btn-white" data-dismiss="modal">Volver</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <div class="modal inmodal fade" id="mdl-cancelar-pedido" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content animated bounceInRight">
            <form method="post" class="unif_modal" enctype="multipart/form-data" action="/inicio/CancelarPedido">
                @csrf
                <input type="hidden" name="cod_det_ped" id="cod_det_ped">
                <input type="hidden" name="cod_ped" id="cod_ped">
                <input type="hidden" name="cod_pro" id="cod_pro">
                <input type="hidden" name="fec_ped" id="fec_ped">
                <input type="hidden" name="index_pedido" id="index_pedido" value="{{$index}} ">
                <input type="hidden" name="cod_tipe" value="{{session('cod_tipe')}}"/>
                <div class="modal-header mh-p">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                    <i class="fa fa-times modal-icon"></i>
                </div>
                <div class="modal-body">
                    <br><h4><div id="mensaje-e"></div></h4><br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o"></i> Aceptar</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <div class="modal inmodal fade" id="mdl-desocupar-mesa" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content animated bounceInRight">
            <form method="post" enctype="multipart/form-data" action="/inicio/Desocupar">
                @csrf
                <input type="hidden" name="cod_pede" id="cod_pede">
                <input type="hidden" name="cod_tipe" value="{{session('cod_tipe')}}"/>
                <div class="modal-header mh-p">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                    <i class="fa fa-sign-out modal-icon"></i>
                </div>
                <div class="modal-body">
                    <br><center><h4>¿Desea desocupar la mesa?</h4></center><br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o"></i> Aceptar</button>
                </div>
            </form>
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
                                Haz alcanzado tu límite de ventas mensuales del Plan <b>Free</b>.  Espera
                                hasta el <b>1ero</b>del siguiente mes o <b>incrementa tu plan !</b>
                            </p>
                        </div>
                    </div>
                    <div class="row m-t-20">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <button onclick="window.location.replace('/inicio')" type="button"  class="btn btn-danger ">Esperar</button>
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
    <script id="pedido-detalle-template" type="text/x-jsrender" src="">

    <li class="list-group-item" style="background: #666666;color: #ffffff; border-radius: 0px; border: 0px; border-top: 1px solid #e7eaec;">
        <div class="row">
            <div class="col-xs-12 col-sm-12 text-left">
                Nuevos pedidos:
            </div>
        </div>
    </li>
    [%for items%]
    <li class="warning-element" style="border-radius: 0px; border: 0px; border-top: 1px solid #e7eaec; border-left: 3px solid #f8ac59">
        <div class="row">
            <input type="hidden" name="producto_id" value="[%:producto_id%]" />
            <input type="hidden" name="precio" value="[%:precio%]"/>
            <div class="col-xs-4 col-md-3 col-sm-3">
                <input class="touchspin1 validanumericos" type="text" value="[%:cantidad%]" name="cantidad" style="text-align: center;" onchange="pedido.actualizar([%:id%], this);">
            </div>
            <div class="col-xs-5 col-md-6 col-sm-6">
                <span name="producto">[%:producto%]</span><br>
                Precio Uni. <span name="total" style="text-align: left;"><b>{{session('moneda')}} [%:precio%]</b><span/>
            </div>
            <div class="col-xs-3 col-md-3 col-sm-3 text-right">
                <button type="button" class="btn btn-primary" onclick="pedido.comentar([%:id%], this);"><i class="fa fa-comment"></i></button>
                <button type="button" class="btn btn-danger" onclick="pedido.retirar([%:id%]);"><i class="fa fa-times"></i></button>
            </div>
            <div id="com[%:id%]" style="display: none;">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <input type="text" name="comentario" class="form-control" value="[%:comentario%]" placeholder="Agrega un comentario aqu&iacute;..." onchange="pedido.actualizar([%:id%], this);"/>
                </div>
            </div>
        </div>
    </li>
    [%else%]
    <li class="text-center list-group-item" style="border-radius: 0px; border: 0px; border-top: 1px solid #e7eaec;">No se han agregado productos al detalle</li>
    [%/for%]
    </li>
    <li class="list-group-item" style="background: #666666;color: #ffffff; border-radius: 0px; border: 0px; border-top: 1px solid #e7eaec;">
        <div class="row">
            <div class="col-xs-12 col-sm-12 text-right">
                Total a confirmar <b>{{session('moneda')}} [%:total%]</b>
            </div>
        </div>
    </li>
    </script>


<script src="{{URL::to('rest/scripts/inicio/func-procesos.js')}}"></script>
<script src="{{URL::to('rest/scripts/inicio/func-cliente.js')}}"></script>
<script src="{{URL::to('rest/js/jquery-ui-1.12.1/jquery-ui.min.js')}}"></script>
<script src="{{URL::to('rest/js/js-render.js')}}"></script>
<script src="{{URL::to('rest/js/jquery.email-autocomplete.min.js')}}"></script>
<script type="text/javascript">
    $('#restau').addClass("active");
</script>
<script type="text/javascript">
    $(function(){

        $('.validanumericos').keypress(function(e) {
            if(isNaN(this.value + String.fromCharCode(e.charCode)))
                return false;
        })
                .on("cut copy paste",function(e){
                    e.preventDefault();
                });

    });
</script>
@endsection