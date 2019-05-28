@extends('layouts.application.master')

@section('content')

<input type="hidden" id="m" value="<?php // echo $_GET['m']; ?>"/>


<div class="wrapper wrapper-content animated bounce">
    <div class="ibox">
        <div class="ibox-title">
            <div class="ibox-title-buttons pull-right">
                <a href="/proveedores/crear" ><button type="button" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Nuevo Proveedor</button></a>
            </div>
            <h5><strong><i class="fa fa-list-ul"></i> Total de los Proveedores</strong></h5>
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
                <table class="table  table-hover table-condensed table-striped" id="table" width="100%">
                    <thead>
                        <tr>
                            <th>Raz&oacute;n Social</th>
                            <th>RUC</th>
                            <th>Direcci&oacute;n</th>
                            <th style="text-align: center">Estado</th>
                            <th style="text-align: center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($proveedores as $r)
                    
                    <tr>
                        <td> {{$r->razon_social}}</td>
                        <td><strong>RUC: </strong>{{ $r->ruc}}</td>
                        <td>{{$r->direccion}}</td>
                        <td style="text-align: center">
                        
                            @if($r->estado == 'a')
                                <a onclick="{{'estadoProveedor('.$r->id_prov.');'}}"><span class="label label-primary">ACTIVO</span>
                            @elseif($r->estado == 'i')
                                <a onclick="{{'estadoProveedor('.$r->id_prov.');'}}"><span class="label label-danger">INACTIVO</span></a>
                            @endif
                        </td>
                        <td style="text-align: center">
                            <a href="/proveedores/editar/{{$r->index_por_cuenta}}">
                                <button type="button" class="btn btn-success btn-xs"><i class="fa fa-edit"></i> Editar</button>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="mdl-estado-proveedor" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content animated bounceInRight">
        <form id="frm-estado-proveedor" method="post" enctype="multipart/form-data" action="/proveedores/Estado">
        @csrf
        <input type="hidden" name="cod_prov" id="cod_prov">
            <div class="modal-header mh-e">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                <i class="fa fa-stack-exchange modal-icon"></i>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                    <div class="form-group">
                        <label class="control-label">Estado</label>
                        <select name="estado" id="estado_proveedor" class="selectpicker show-tick form-control" data-live-search-style="begins" data-live-search="true" title="Seleccionar" autocomplete="off" required="required">
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

<script src="{{URL::to('rest/scripts/compras/proveedores/func_prov.js')}}"></script>
@endsection