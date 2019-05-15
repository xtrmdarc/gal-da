@extends('layouts.application.master')

@section('content')
<div class="wrapper wrapper-content animated shake">
    <div class="ibox">
        <div class="ibox-title">
            <div class="ibox-title-buttons pull-right">
                <a class="btn btn-warning" href="{{session('home')}} "> <i class="fa fa-arrow-left"></i> Atrás </a>
                <a class="btn btn-success" onclick="nuevo_resumen()" > <i class="fa fa-plus"></i> Nuevo resumen </a>
            </div>
            <h5>Consulta de resumen diario</h5>
        </div>
        <div class="ibox-content form-modern" style="position: relative; min-height: 30px;">
            {{-- filtros --}}
            <form id="frm-buscar-resumenes" action="/buscarResumenes" method="POST">
            <input type="hidden" name="cliente_id" id="cliente_id">
            <input type="hidden" name="aux_cliente_nombre" id="aux_cliente_nombre">
            <div class="row">
                <div class="col-sm-12">
                    <div class="row px-3">
                        
                        {{-- <div class="col-sm-10 form-group ">
                            <div class="row">
                        
                                <label for="" class="col-sm-4 col-md-3 ">Cliente</label>
                                <input type="text" id="cliente_nombre" name="cliente_nombre" class="form-control col-sm-8 col-md-9"  autocomplete="off">
                            </div>
                        </div> --}}
                        <div id="div_comprobantes_enviar" class="col-sm-12 p-2 border border-info bg-light rounded mb-3" style="display:none;">
                            <p id="mensaje_ce" style="display:none">Tienes documentos para enviar, crea un nuevo resumen para enviarlos. [Boletas y sus notas]</p>
                        </div>
                        <div class="col-sm-4 form-group " >
                            <div class="row">
                                <label for="" class="col-sm-5 col-md-4 col-lg-3">F. Inicio</label>
                                {{--  --}}
                                <input type="text" name="fecha_inicio" class="form-control datepicker col-sm-7 col-md-8 col-lg-9" autocomplete="off" >
                            </div>
                        </div>

                        <div class="col-sm-4 form-group ">
                            <div class="row">
                                <label for=" " class="col-sm-5 col-md-4 col-lg-3">F. Final</label>
                                {{--  --}}
                                <input type="text" name="fecha_final" class="form-control datepicker col-sm-7 col-md-8 col-lg-9"  autocomplete="off">
                            </div>
                        </div>

                        <div class="col-sm-4 form-group ">
                            <div class="row">
                                
                                <button id="btn-consultar" type="submit" class="btn btn-success form-control col-sm-8 col-md-10 mx-auto" style="font-weight:800;" data-loading-text="CONSULTANDO..">CONSULTAR</button>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="row">
                        @php
                        /*
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
                        */
                        @endphp
                        

                    </div>
                </div>
                
            </div>
            </form>
            {{-- tabla --}}
            <div class="row">
                <div class="col-sm-12">
                    <table id="table-resumen-comprobante" class="table " style="position:relative" >
                        <thead>
                            <tr>
                                {{-- <th>Serie</th>
                                <th>Número</th> --}}
                                <th>Identificador</th>
                                <th style="min-width:100px;">Fecha comprobates</th>
                                <th style="min-width:100px;">Fecha emisión</th>
                                {{-- <th>Cliente</th> --}}
                                <th>Estado</th>
                                <th >Mensaje SUNAT</th>
                                <th>Visualizar</th>
                                
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

<div class="modal inmodal fade" id="mdl-nuevo-resumen" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="true">
    <div class="modal-dialog modal-lg"> 
        <div class="modal-content animated bounceInRight">
            <form id="frm-buscar-docs" action="resumen/BuscarDocsPorFecha">
            @csrf
            <div class="modal-header">
                {{-- <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button> --}}
                <h4 class="modal-title">Nuevo Resumen</h4>
            </div>
            <div class="modal-body">
                {{-- Buscar docs para resumen por fecha --}}
                
                    <div class="container-fluid px-0">
                        <div class="row">
                            <div class="col-sm-6 " >
                                <div class="row">
                                    <label for="fecha" class="col-sm-4">Fecha</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="fecha" class="form-control datepicker " autocomplete="off" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="row justify-content-end">
                                    <div class="col-sm-8 float-right">
                                        <input id="btn_buscar_docs" type="submit" class="btn btn-success btn-block"  value="BUSCAR">    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
               
                {{-- Tabla docs --}}
                <table id="table_docs_resumen" class="table">
                    <thead>
                        <tr>
                            <th>Inlcuido</th>
                            <th>Fecha</th>
                            <th>Serie</th>
                            <th>Numero</th>
                            <th>Tipo</th>
                            <th>Monto</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>


            </form>
            </div>
            <div class="p-3">
                <div id="div_mensaje_respuesta" class=" container  p-2 border border-info bg-light rounded mb-3" style="display:none;">
                    <div class="row">
                        <div class="col-sm-6">
                            <label id="estado_resumen" ></label>
                        </div>
                        <div class="col-sm-6">
                            <p id="mensaje_sunat"></p>
                        </div>
                    </div>
                    
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cancelar</button>
                <button  id="btn_enviar_resumen" type="submit" onclick="enviarResumen()" class="btn btn-primary"><i class="fa fa-save"></i> Crear</button>
            </div>

        </div>
    </div>
</div>

<div class="modal inmodal fade" id="mdl-estado-resumen" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="true">
    <div class="modal-dialog modal-md"> 
        <div class="modal-content animated bounceInRight">
            @csrf
            <div class="modal-header">
                {{-- <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button> --}}
                <h4 class="modal-title">Resumen diario</h4>
            </div>
            <div class="modal-body">
                {{-- Buscar docs para resumen por fecha --}}
                <div class="container">
                    <div class="row">
                        <div class="col-sm-4">
                            <label for="">Resumen ID</label>
                        </div>
                        <div class="col-sm-8">
                            <p id="mdl_resumen_id"></p>
                        </div>
                        <div class="col-sm-4">
                            <label for="">Fecha resumen</label>
                        </div>
                        <div class="col-sm-8">
                            <p id="mdl_fecha_resumen"></p>
                        </div>
                        <div class="col-sm-4">
                            <label for="">Fecha comprobantes</label>
                        </div>
                        <div class="col-sm-8">
                            <p id="mdl_fecha_comprobantes"></p>
                        </div>
                        <div class="col-sm-4">
                            <label for="">Estado</label>
                        </div>
                        <div class="col-sm-8">
                            <p id="mdl_estado"></p>
                        </div>
                        <div class="col-sm-4">
                            <label for="">Mensaje sunat</label>
                        </div>
                        <div class="col-sm-8">
                            <p id="mdl_mensaje_sunat"></p>
                        </div>
                        <div class="col-sm-4">
                            <label for="">Acciones</label>
                        </div>
                        <div class="col-sm-8">
                            <div id="mdl_acciones" class="row" >

                            </div>
                        </div>
                    </div>
                </div>

                <h5 >Documentos asociados</label>
                {{-- Tabla docs --}}
                <table id="table_docs_resumen_estado" class="table">
                    <thead>
                        <tr>
                            {{-- <th>Inlcuido</th> --}}
                            {{-- <th>Fecha</th> --}}
                            <th>Serie</th>
                            <th>Numero</th>
                            <th>Tipo</th>
                            <th>Monto</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cancelar</button>
                <button id="btn_resumen_estado_modal" type="submit" class="btn btn-primary" data-dismiss="modal"> Aceptar</button>
            </div>

        </div>
    </div>
</div>

@endsection()

@section('scripts')
    {{-- <script src="{{URL::to('rest/js/jquery.email-autocomplete.min.js')}}"></script> --}}
    <script src="{{URL::to('rest/js/jquery-ui-1.12.1/jquery-ui.min.js')}}"></script>
    <script type="text/javascript">
        $('.datepicker').datepicker({
        }).datepicker('setDate',new Date());
    </script>
    <script src="{{URL::to('rest/scripts/comprobantes/resumenes.js')}} "> </script>
@endsection()