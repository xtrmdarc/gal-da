@extends('layouts.master')
@section('content')
<input type="hidden" id="m" value="<?php// echo $_GET['m']; ?>"/>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2><i class="fa fa-users"></i> <a href="?c=Cliente" class="a-c">Clientes</a></h2>
        <ol class="breadcrumb">
            <li class="active">
                <strong>Clientes</strong>
            </li>
            <li>
                Lista
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated bounce">
    <div class="ibox">
        <div class="ibox-title">
            <div class="ibox-title-buttons pull-right">
                <a href="cliente_e" ><button type="button" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Nuevo Cliente</button></a>
            </div>
            <h5><strong><i class="fa fa-list-ul"></i> Lista de Clientes</strong></h5>
        </div>
        <div class="ibox-content">
            <div class="row" >
                <div class="col-sm-4 col-sm-offset-8" style="text-align:right;" id="filter_global">
                    <div class="input-group">
                        <input class="form-control global_filter" id="global_filter" type="text">
                        <span class="input-group-btn">
                            <button class="btn btn btn-primary"> <i class="fa fa-search"></i></button>
                        </span>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-condensed table-striped" id="table" width="100%">
                    <thead>
                        <tr>
                            <th>Cliente/Raz&oacute;n Social</th>
                            <th>DNI</th>
                            <th>RUC</th>
                            <th>Direcci&oacute;n</th>
                            <th style="text-align: center">Estado</th>
                            <th style="text-align: center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($clientes as $r)
                    
                    <tr>
                        <td>{{$r->nombre}}</td>
                        <td>{{$r->dni}}</td>
                        <td>{{$r->ruc}}</td>
                        <td>{{$r->direccion}}</td>
                        <td style="text-align: center">
                        @if($r->estado == 'a')
                                <a onclick="estadoCliente('.$r->id_cliente.');"><span class="label label-primary">ACTIVO</span></a>
                        @elseif($r->estado == 'i')
                                <a onclick="estadoCliente('.$r->id_cliente.');"><span class="label label-danger">INACTIVO</span></a>
                        @endif
                        </td>
                        <td style="text-align: right">
                            <a href="{{url('cliente_e/'.$r->id_cliente)}}" class="btn btn-success btn-xs">
                            <i class="fa fa-edit"></i> Editar</a>
                            <button type="button" class="btn btn-danger btn-xs" onclick="eliminarCliente({{$r->id_cliente.',\''. $r->nombre.'\''}});"><i class="fa fa-trash-o"></i></button>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="mdl-estado-cliente" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content animated bounceInRight">
        <form id="frm-estado-cliente" method="post" enctype="multipart/form-data" action="Estado">
        <input type="hidden" name="cod_cliente" id="cod_cliente">
            <div class="modal-header mh-e">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                <i class="fa fa-stack-exchange modal-icon"></i>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                    <div class="form-group">
                        <label class="control-label">Estado</label>
                        <select name="estado" id="estado_cliente" class="selectpicker show-tick form-control" data-live-search-style="begins" data-live-search="true" title="Seleccionar" autocomplete="off" required="required">
                            <option value="a">ACTIVO</option>
                            <option value="i">INACTIVO</option>
                        </select>
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

<div class="modal inmodal fade" id="mdl-eliminar-cliente" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content animated bounceInRight">
        <form id="frm-eliminar-cliente" method="post" enctype="multipart/form-data" action="cliente/Eliminar">
            @csrf
        <input type="hidden" name="cod_cliente_e" id="cod_cliente_e">
            <div class="modal-header mh-p">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                <i class="fa fa-trash-o modal-icon"></i>
            </div>
            <div class="modal-body">
                <div id="mensaje-c"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o"></i> Aceptar</button>
            </div>
        </form>
        </div>
    </div>
</div>

<script src="{{URL::to('scripts/cliente/func_cliente.js')}}"></script>

@endsection