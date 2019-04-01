@extends('layouts.application.master')

@section('content')
<div class="wrapper wrapper-content animated shake">
    <div class="ibox">
        <div class="ibox-title">
            <div class="ibox-title-buttons pull-right">
                <a class="btn btn-warning" ui-sref="informes.ventas" href="{{session('home')}}"> <i class="fa fa-arrow-left"></i> Atrás </a>
                <a class="btn btn-success" onclick="nueva_nota()" > <i class="fa fa-plus"></i> Nueva nota </a>
            </div>
            <h5>Consulta de nota de crédito</h5>
        </div>
        <div class="ibox-content form-modern" style="position: relative; min-height: 30px;">
            {{-- filtros --}}
            <form id="frm-buscar-facturas" action="/buscarFacturas" method="POST">
            <input type="hidden" name="cliente_id" id="cliente_id">
            <input type="hidden" name="aux_cliente_nombre" id="aux_cliente_nombre">
            <div class="row">
                    <div class="col-sm-6">
                        <div class="row">

                            <div class="col-sm-10 form-group">
                                <div class="row">
                                    <label for="" class="col-sm-4 col-md-3">Documento</label>
                                    <input type="text" name="documento" class="form-control col-sm-8 col-md-9" placeholder="F001-00000123"  autocomplete="off">
                                </div>
                            </div>
                            
                            <div class="col-sm-10 form-group ">
                                <div class="row">
                           
                                    <label for="" class="col-sm-4 col-md-3 ">Cliente</label>
                                    <input type="text" id="cliente_nombre" name="cliente_nombre" class="form-control col-sm-8 col-md-9"  autocomplete="off">
                                </div>
                            </div>
    
    
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="row">
                            
                            <div class="col-sm-10 form-group">
                                <div class="row">
                                    <label for=" " class="col-sm-4 col-md-3">Fecha </label>
                                    {{--  --}}
                                    <input type="text" name="fecha_final" class="form-control datepicker col-sm-8 col-md-9"  autocomplete="off">
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
                    <table id="table-nota-cred-comprobante" class="table " style="position:relative" >
                        <thead>
                            <tr>
                                <th>Documento</th>
                                <th>Fecha emisión</th>
                                <th>Doc. afectado</th>
                                <th>Estado</th>
                                <th>Mensaje SUNAT</th>
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
<div class="modal inmodal fade" id="mdl-nueva-nota-cred" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="true">
    <div class="modal-dialog modal-lg"> 
        <div class="modal-content animated bounceInRight">
            <form id="frm-buscar-comprobante" >
            @csrf
            <div class="modal-header">
                {{-- <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button> --}}
                <h4 class="modal-title">Nueva nota de crédito</h4>
            </div>
            <div class="modal-body">
                {{-- Buscar docs para resumen por fecha --}}
                
                <div class="container-fluid px-0">
                    <div class="row">
                        <div class="col-sm-6 " >
                            <div class="row">
                                <label for="mtovio" class="col-sm-12 col-md-4">Motivo</label>
                                <div class="col-sm-12 col-md-8">
                                    {{-- <input type="text" name="motivo" class="form-control  " autocomplete="off" > --}}
                                    <select name="motivo_nota" id="motivo_nota" class="form-control" required>
                                        <option value="">Seleccionar</option>
                                        @foreach($motivos_nota_cred as $motivo)
                                            <option value="{{$motivo->id_motivo_nota_cred}} ">{{$motivo->descripcion}} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 " >
                            <div class="row">
                                <label for="documento" class="col-sm-12 col-md-4">Documento</label>
                                <div class="col-sm-12 col-md-8">
                                    <input type="text" name="documento" id="documento" class="form-control  " autocomplete="off" placeholder="XXXX-XXXXXXXX" required>
                                </div>
                            </div>
                        </div>
                        

                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-6 " >
                            <div class="row">
                                <label for="documento" class="col-sm-12 col-md-4">Sustento</label>
                                <div class="col-sm-12 col-md-8">
                                    <input type="text" name="sustento" id="sustento" class="form-control  " autocomplete="off" required >
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 ">
                            <div class="row justify-content-end">
                                <label for="documento" class="col-sm-12 col-md-4">&nbsp;</label>
                                <div class="col-sm-12 col-md-8 float-right">
                                    <input id="btn_buscar_comprobante" type="submit" class="btn btn-success btn-block"  value="BUSCAR">    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="div_datos_comprobante" class="container-fluid px-0 border-top pt-3 pb-1" >
                    <div class="row">
                        <div class="col-sm-4 ">
                            <label for="">Documento</label>
                            <p id="folio_dc"></p>
                        </div>
                        <div class="col-sm-4">
                            <label for="">Cliente</label>
                            <p id="cliente_dc"></p>
                        </div>
                        <div class="col-sm-4">
                            <label for="">Monto Total</label>
                            <p id="total_dc"></p>
                        </div>
                    </div>
                </div>
                {{-- Tabla docs --}}
                <div class="table-responsive">
                    <table id="table-detalle-comprobante" class="table table-hover">
                        <thead>
                            <tr>
                                <th>Tipo</th>
                                <th>Descripcion</th>
                                <th>Cantidad</th>
                                <th>P. unitario</th>
                                <th>P. Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
    
                        </tbody>
                        <tfoot >
                            <tr >
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td> 
                                <th scope="row" class="text-right">Subtotal</th>
                                <td id="subtotal_nota" class="text-right"></td>
                            </tr>
                            <tr >
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <th scope="row" class="text-right">IGV</th>  
                                <td id="igv_nota" class="text-right"></td>
                            </tr>
                            <tr >
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <th scope="row" class="text-right">Total</th>  
                                <td id="total_nota" class="text-right" ></td>
                            </tr>
                        </tfoot>
                    </table>
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

            </form>
            </div>
            
            
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cancelar</button>
                <button  id="btn_enviar_nota" type="submit"  class="btn btn-primary"><i class="fa fa-save"></i> Crear</button>
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
    <script src="{{URL::to('rest/scripts/comprobantes/nota_cred.js')}} "> </script>
@endsection()