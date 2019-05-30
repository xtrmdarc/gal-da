@extends('layouts.application.master')
@section('content')


<input type="hidden" id="igv" value="{{number_format(session('igv_session'),2)}}"/>
<input type="hidden" id="moneda" value="{{session('moneda')}}"/>


<form id="form-compra" method="post" action="/compras/GuardarCompra">
@csrf
<div class="wrapper wrapper-content animated fadeIn">
  <div class="ibox">
    <div class="ibox-title">
      <div class="ibox-title-buttons pull-right">
        <a class="btn btn-default" href="/compras/"> Cancelar</a>&nbsp;
        <button class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;Guardar</button>
      </div>
      <h5><strong><i class="fa fa-list-ul"></i> Detalle de compra</strong></h5>
    </div>
    <div class="ibox-content bg-gray-c">
      <div class="row">
				<div class="col-sm-6">
          <div class="panel panel-default panel-shadow">
		        <div class="panel-body">
		        	<div class="form-group">
		        		<label class="control-label">Proveedor</label>
                <div class="row">
    							<div class="col-sm-9">
  									<div class="input-group">
    									<input type="hidden" id="cod_prov"/>
                			<input type="text" id="busc_prov" class="form-control" placeholder="B&uacute;squeda del proveedor..." autocomplete="off" value="" />
                                <button id="btnProvLimpiar" class="btn btn-danger" type="button">
                                    <span class="fa fa-times"></span>
                                </button>
				            </div>
					        </div>
    							<div class="col-sm-3">
    								<button type="button" class="btn btn-primary btn-block" onclick="nuevoProveedor();"><i class="fa fa-plus-circle"></i> Nuevo</button>
    							</div>
	    					</div>
              </div>
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <input type="text" id="dato_prov" class="form-control" placeholder="Datos del proveedor..." readonly="off" autocomplete="off" />
                    </div>
                  </div>
                </div>
            </div>
          </div>
        </div>
	    	<div class="col-sm-6">
          <div class="panel panel-default panel-shadow">
            <div class="panel-body">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label class="control-label">Fecha</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                      <input type="text" name="compra_fecha" id="compra_fecha" class="form-control DatePicker" required="required" placeholder="Fecha de compra" readonly="true">
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label class="control-label">Hora</label>
                    <div class="input-group clockpicker" data-autoclose="true">
                      <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                          <input type="text" name="compra_hora" id="compra_hora" class="form-control" required="required" placeholder="Hora de compra" readonly="true">
                      </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <select name="tipo_doc" id="tipo_doc" class="selectpicker show-tick form-control"  data-live-search="true" title="Seleccionar Documento" autocomplete="off" required="required">
                      @foreach($documentos as $doc)
                        <option value="{{$doc->id_tipo_doc}} ">{{$doc->descripcion}} </option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <div class="input-group display-flex">
                      <input type="text" name="serie_doc" id="serie_doc" class="form-control text-right" placeholder="Serie" autocomplete="off" />
                      <span class="input-group-addon">-</span>
                      <input type="text" name="num_doc" id="num_doc" class="form-control" placeholder="N&uacute;mero" required="required" autocomplete="off" />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
	    </div>
      <div class="row">
        <div class="col-sm-12">
          <div class="panel panel-default panel-shadow">
            <div class="panel-body">
                <meta name="csrf-token" content="{{ csrf_token() }}">
              <table class="table table-condensed table-striped table-hover" id="table-alm">
                <thead>
                  <tr>
                    <th>B&uacute;squeda del producto/insumo</th>
                    <th>U.M.</th>
                    <th>Cantidad</th>
                    <th>Precio Unit.</th>
                    <th class="text-right">Acci&oacute;n</th>
                  </tr>
                </thead>
                <tbody >
                  <tr>
                    <td class="col-xs-5">
                      <input id="tipo_prod" type="hidden" value="0" />
                      <input id="insumo_id" type="hidden" value="0" />
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-search"></i></span>
                        <input autocomplete="off" id="b_insumo" class="form-control" type="text" placeholder="Nombre del producto o insumo" />
                      </div>
                    </td>
                    <td class="col-xs-2 center-v"><div id="desc_um">U.M.</div></td>
                    <td class="col-xs-2 dec">
                        <input autocomplete="off" id="cant_bins" class="form-control" type="text" placeholder="Cantidad" />
                    </td>
                    <td class="col-xs-2">
                      <div class="input-group dec">
                        <span class="input-group-addon" id="basic-addon1">{{session('moneda')}}</span>
                        <input autocomplete="off" id="precio_bins" class="form-control" type="text" placeholder="Precio" />
                      </div>
                    </td>
                    <td class="col-xs-1">
                      <button class="btn btn-block btn-primary" id="btn-agregar" type="button"><i class="fa fa-plus-circle"></i></button>
                    </td>
                  </tr>
                </tbody>
              </table>
              <ul id="compra-detalle" class="sortable-list agile-list">
                <div id="lizq-s" style="display: block;">
                  <div class="panel panel-transparent panel-dashed tip-sales text-center">
                    <div class="row">
                      <div class="col-sm-8 col-sm-push-2">
                        <i class="fa fa-warning fa-3x text-warning"></i>
                        <h3 class="ich m-t-none">No hay detalles de la compra</h3>
                      </div>
                    </div>
                  </div>
                </div>
              </ul>
            </div>
          </div>
        </div>
      </div>			
		  <div class="row">
        <div class="col-sm-6">
          <div class="panel panel-default panel-shadow">
            <div class="panel-body">
              <div class="row" style="padding: 10px 10px 0px 10px;">
                <div class="col-sm-8">
                  <div class="form-group">
                    <label class="control-label">Tipo de Compra</label>
                    <div class="row">
                      <div class="col-sm-6">
                        <label style="font-weight: 500"><input name="tipo_compra" id="contado" type="radio" value="1" class="flat-red" checked="true"> Compra al contado</label>
                      </div>
                      <div class="col-sm-6">
                        <label style="font-weight: 500" id="lbl-credito"><input name="tipo_compra" id="credito" type="radio" value="2" class="flat-red"> Compra al cr&eacute;dito</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-4 text-right">
                  &nbsp;
                </div>
              </div>
              <div id="r-contado" style="display: block;">
                <hr/>
                <div class="row">
                  <div class="col-sm-3">
                    <div class="form-group display-flex dec">
                      <label class="control-label">Monto total</label>
                      <div class="input-group date">
                        <span class="input-group-addon">{{session('moneda')}}</span><input class="form-control" type="text" name="monto_con" id="monto_con"/>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-1 hidden-xs text-center p-t-xs">
                    <i class="fa fa-minus m-t-lg"></i> 
                  </div>
                  <div class="col-sm-3">
                    <div class="form-group display-flex dec">
                      <label class="control-label">Monto descuento</label>
                        <div class="input-group date">
                          <span class="input-group-addon">{{session('moneda')}}</span><input class="form-control" type="text" id="desc_comp" value="0.00">
                        </div>
                    </div>
                  </div>
                  <div class="col-sm-5 text-right">
                    <div class="amount-big">
                      <span class="title">Subtotal: </span>
                      <span class="the-number sb_tc">{{session('moneda')}} 0.00</span>
                    </div>
                    <div class="amount-big">
                      <span class="title">IGV: </span>
                      <span class="the-number igv_tc">{{session('moneda')}} 0.00</span>
                    </div>
                  </div>
                </div>
              </div>
              <div id="mensaje-cre"></div>
            </div>
          </div>
      </div>
      <div class="col-sm-6">
        <div class="panel panel-default panel-shadow bg-gray-c">
          <div class="panel-body">
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label class="control-label">Observaciones</label>
                  <textarea name="observaciones" id="observaciones" class="form-control" rows="2">Ninguna</textarea>
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

<div class="modal inmodal fade" id="mdl-compra-credito" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header mhs-e">
                <h4 class="mt">Detalle de las cuotas</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                	<div class="col-sm-4">
    					<div class="form-group">
                  <label class="control-label">Monto total</label>
                  <div class="input-group dec">
                      <span class="input-group-addon">{{session('moneda')}}</span>
                      <input class="form-control" type="text" name="monto_cre" id="monto_cre" value="0.00">
                  </div>
              </div>
    				</div>
                	<div class="col-sm-4">
    					<div class="form-group">
                  <label class="control-label">N&uacute;mero de cuotas</label>
                  <div class="input-group ent">
                      <span class="input-group-addon"><i class="fa fa-slack"></i></span>
                      <input class="form-control" type="text" name="nro_cuotas" id="nro_cuotas" value="">
                  </div>
              </div>
    				</div>
    				<div class="col-sm-4">
    					<div class="form-group">
                  <label class="control-label">Inter&eacute;s</label>
                  <div class="input-group ent">
                      <span class="input-group-addon"><i class="fa fa-deviantart"></i></span>
                      <input class="form-control" type="text" name="monto_int" id="monto_int" value="0">
                  </div>
              </div>
    				</div>
                </div>
               	<div class="table-responsive">
               		<table class="table table-hover table-striped">
               			<thead>
               				<tr>
               					<th>Total</th>
               					<th>Interes</th>
               					<th>Fecha de pago</th>
               				</tr>
               			</thead>
               			<tbody id="lis" class="display-flex dec">
               			</tbody>
               		</table>
               	</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary btn-ac" data-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>
</form>

<div class="modal inmodal fade" id="mdl-nuevo-proveedor" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated bounceInTop unif_modal">
            <div class="modal-header mhs-e">
                <h4 class="mt">Nuevo Proveedor</h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
		                <div class="col-lg-6 col-lg-offset-6">
		                <form method="post" id="frm-consulta-ruc">
		                    <div class="form-group">
		                        <div class="input-group">
		                            <input type="text" name="ruc_numero" id="ruc_numero" class="form-control" placeholder="Ingrese RUC" autocomplete="off" />
                                    <button id="btnBuscar" class="btn btn-primary" type="submit"><span class="fa fa-search"></span></button>
		                        </div>
		                    </div>
		                </form>
		                </div>
		            </div>
                <form method="post" id="form_p">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">Raz&oacute;n Social</label>
                                    <input type="text" name="razon_social" id="razon_social" class="form-control" placeholder="Ingrese raz&oacute;n social" autocomplete="off" required />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">RUC</label>
                                    <input type="text" name="ruc" id="ruc" data-mask="99999999999" class="form-control" placeholder="Ingrese ruc" autocomplete="off" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">Direcci&oacute;n</label>
                                    <input type="text" name="direccion" id="direccion" class="form-control" placeholder="Ingrese direcci&oacute;n" autocomplete="off" required />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">Tel&eacute;fono</label>
                                    <input type="text" name="telefono" id="telefono" data-mask="999999999" class="form-control" placeholder="Ingrese tel&eacute;fono" autocomplete="off" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">Correo electr&oacute;nico</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Ingrese correo electr&oacute;nico de la empresa" autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">Contacto</label>
                                    <input type="text" name="contacto" id="contacto" class="form-control" placeholder="Ingrese nombre del contacto" autocomplete="off" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="RegistrarProveedor"><i class="fa fa-save"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>


<script id="compra-detalle-template" type="text/x-jsrender" src="">
    <li class="list-group-item list-group-item-warning disabled">
        <div class="row">
            <div class="col-xs-2">
                <center><label style="font-weight: bold;text-align: center;">Cantidad</label></center>
            </div>
            <div class="col-xs-5">
                <label style="font-weight: bold;">Producto/Insumo</label>
            </div>
            <div class="col-xs-2">
                <center><label style="font-weight: bold;text-align: center;">Precio Unit.</label></center>
            </div>
            <div class="col-xs-2">
                <center><label style="font-weight: bold;text-align: center;">Importe</label></center>
            </div>
            <div class="col-xs-1">
                <center><label style="font-weight: bold;text-align: center;">Acci&oacute;n</label></center>
            </div>
        </div>
    </li>
    [%for items%]
    <li class="warning-element">
        <div class="row">
          <div class="col-sm-2">
                <input name="cant_ins" class="form-control" type="text" placeholder="Cantidad" value="[%:cant_ins%]"  style="text-align:center;" autocomplete="off" onchange="compra.actualizar([%:id%], this);"/>
            </div>
            <div class="col-xs-5">
                <input name="tipo_p" type="hidden" value="[%:tipo_p%]" />
                <input name="cod_ins" type="hidden" value="[%:cod_ins%]" />
                <label class="label label-info" name="desc_ins">[%:desc_ins%]</label><br><label name="nomb_ins">[%:nomb_ins%]</label>
            </div>
            <div class="col-sm-2">
                <div class="input-group">
                  <span class="input-group-addon" id="basic-addon1"><?php echo session("moneda"); ?></span>
                  <input name="precio_ins" class="form-control" type="text" placeholder="Precio" value="[%:precio_ins%]" onchange="compra.actualizar([%:id%], this);"/>
                </div>
            </div>
            <div class="col-sm-2">
                <input type="text" name="importe" class="form-control" style="text-align:center;border-style: none;background: #fff;cursor: default;font-size: 12px;" value="[%:total%]" disabled="true" />
            </div>
            <div class="col-sm-1 text-right">
                <button type="button" class="btn btn-danger" onclick="compra.retirar([%:id%]);"><i class="fa fa-trash-o"></i></button>
            </div>
        </div>
    </li>
    [%else%]
    <li class="text-center list-group-item">No se han agregado insumos al detalle</li>
    [%/for%]
</script>

<script src="{{URL::to('rest/js/jquery-ui-1.12.1/jquery-ui.min.js')}}"></script>
<script src="{{URL::to('rest/scripts/compras/func-compra-nueva.js')}}"></script>
<script src="{{URL::to('rest/scripts/compras/func-prov.js')}}"></script>
<script src="{{URL::to('rest/js/js-render.js')}}"></script>
<script src="{{URL::to('rest/js/jquery.email-autocomplete.min.js')}}"></script>
<script src="{{URL::to('rest/js/plugins/clockpicker/clockpicker.js')}}"></script>
<script type="text/javascript">
$(function() {
    $('#compras').addClass("active");
    $('#c-compras').addClass("active");
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-red',
      radioClass: 'iradio_flat-red'
    });
    $('.clockpicker').clockpicker({
    	twelvehour: true,
    	autoclose: true
    });
    $("#email").emailautocomplete({
      domains: [
        "gmail.com",
        "yahoo.com",
        "hotmail.com",
        "live.com",
        "facebook.com",
        "outlook.com"
        ]
    });
});
</script>
@endsection