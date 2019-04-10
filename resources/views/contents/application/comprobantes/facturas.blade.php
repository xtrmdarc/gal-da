@extends('layouts.application.master')

@section('content')
<div class="wrapper wrapper-content animated shake">
    <div class="ibox">
        <div class="ibox-title">
            <div class="ibox-title-buttons pull-right">
                <a class="btn btn-warning" ui-sref="informes.ventas" href="{{session('home')}}"> <i class="fa fa-arrow-left"></i> Atrás </a>
            </div>
            <h5>Consulta de facturas de venta</h5>
        </div>
        <div class="ibox-content form-modern" style="position: relative; min-height: 30px;">
            {{-- filtros --}}
            <form id="frm-buscar-facturas" action="/buscarFacturas" method="POST">
            <input type="hidden" name="cliente_id" id="cliente_id">
            <input type="hidden" name="aux_cliente_nombre" id="aux_cliente_nombre">
            <div class="row">
               
                    <div class="col-sm-6">
                        <div class="row">
                            
                            <div class="col-sm-10 form-group ">
                                <div class="row">
                           
                                    <label for="" class="col-sm-4 col-md-3 ">Cliente</label>
                                    <input type="text" id="cliente_nombre" name="cliente_nombre" class="form-control col-sm-8 col-md-9"  autocomplete="off">
                                </div>
                            </div>
    
                            <div class="col-sm-10 form-group">
                                <div class="row">
                                    <label for="" class="col-sm-4 col-md-3">F. Inicio</label>
                                    {{--  --}}
                                    <input type="text" name="fecha_inicio" class="form-control datepicker col-sm-8 col-md-9" autocomplete="off" >
                                </div>
                            </div>
    
                            <div class="col-sm-10 form-group">
                                <div class="row">
                                    <label for=" " class="col-sm-4 col-md-3">F. Final</label>
                                    {{--  --}}
                                    <input type="text" name="fecha_final" class="form-control datepicker col-sm-8 col-md-9"  autocomplete="off">
                                </div>
                            </div>
    
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-10 form-group">
                                <div class="row">
                                    <label for="" class="col-sm-4 col-md-3">Tipo Doc.</label>
                                    <select name="tipo_doc" id="tipo_doc" class="form-control col-sm-8 col-md-9">
                                        {{-- foreach --}}
                                        
                                        @foreach($tipos_doc as $td)
                                            <option value="{{$td->id_tipo_doc}} ">{{$td->descripcion}}</option>
                                        @endforeach
    
                                    </select>
                                </div>
                                
                            </div>
                            <div class="col-sm-10 form-group">
                                <div class="row">
                                    <label for="" class="col-sm-4 col-md-3">Documento</label>
                                    <input type="text" name="documento" class="form-control col-sm-8 col-md-9" placeholder="F001-00000123"  autocomplete="off">
                                </div>
                            </div>
    
                            <div class="col-sm-10 form-group">
                                <div class="row">
                                    <label for=""  class="col-sm-4 col-md-3">&nbsp;</label>
                                    <button id="btn-consultar" type="submit" class="btn btn-success form-control col-sm-8 col-md-9" style="font-weight:800;" data-loading-text="CONSULTANDO..">CONSULTAR</button>
                                </div>
                            </div>
    
                        </div>
                    </div>
                
            </div>
            </form>
            {{-- tabla --}}
            <div class="row">
                <div class="col-sm-12">
                    <table id="table-factura-comprobante" class="table " style="position:relative" >
                        <thead>
                            <tr>
                                <th>Serie</th>
                                <th>Número</th>
                                <th>Fecha emisión</th>
                                <th>Cliente</th>
                                <th>Estado</th>
                                <th>Mensaje SUNAT</th>
                                <th>Visualizar</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>                    
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection()

@section('scripts')
    <script src="{{URL::to('rest/js/jquery.email-autocomplete.min.js')}}"></script>
    <script src="{{URL::to('rest/js/jquery-ui-1.12.1/jquery-ui.min.js')}}"></script>
    <script type="text/javascript">
        $('.datepicker').datepicker({
        }).datepicker('setDate',new Date());
    </script>
    <script src="{{URL::to('rest/scripts/comprobantes/factura.js')}} "> </script>
@endsection()