//Declaracion de clases
var nota;
// Clase nota_detalle
class NotaDetalle{

    constructor(id,detalle,tabla,codigo_manejado,nota) {
        console.log(detalle);
        this.codigo_manejado = codigo_manejado;
        this.nota = nota;
        this.id = id;

        this.descripcion = detalle.descripcion;
        this.cantidad = parseInt(detalle.cantidad);
        this.precio_unitario = parseFloat(detalle.mto_precio_unitario).toFixed(2);
        this.precio_total = parseFloat((this.cantidad * this.precio_unitario)/1.00).toFixed(2);
        this.mto_valor_unitario = parseFloat(detalle.mto_valor_unitario).toFixed(2);
        this.mto_valor_venta = parseFloat(detalle.mto_valor_venta).toFixed(2);
        this.mto_base_igv = parseFloat(detalle.mto_base_igv).toFixed(2);
        this.table = tabla;
        this.cod_producto = detalle.cod_producto;
        this.porcentaje_igv = detalle.porcentaje_igv;
        this.igv = detalle.igv;
        this.tip_afe_igv = detalle.tip_afe_igv;
        this.total_impuestos = detalle.total_impuestos;
        this.igv = detalle.igv;
        // Es producto o servicio, NIU para productos, ZZ para servicios.
        this.tipo_producto  = detalle.tipo_producto;
        if(this.tipo_producto == 1) this.unidad = 'NIU'; else this.unidad = 'ZZ';

        this.id_tr_nota_detalle = ''+this.id+'_tr_nota_detalle';
        this.id_icon_remove = ''+this.id+'_icon_remove';

        this.id_txt_descripcion = ''+this.id+'_txt_descripcion';
        this.id_txt_cantidad = ''+this.id+'_txt_cantidad';
        this.id_txt_precio_unitario = ''+this.id+'_txt_punitario';
        this.id_td_precio_total = ''+this.id+'_td_ptotal';
    }

    bindComponents()
    {
        let $self = this;
        $('#'+this.id_icon_remove).on('click',function(){
            $self.eliminar();
        });

        $('#'+this.id_txt_descripcion).on('click',function(){
            
        });

        $('#'+this.id_txt_cantidad).keyup(function(e){
            
            let cantidad = 0;

            cantidad = parseInt($('#'+$self.id_txt_cantidad).val())?parseInt($('#'+$self.id_txt_cantidad).val()):0.00;

            $self.cantidad = cantidad
            $self.actualizarMontos();
        });

        $('#'+this.id_txt_precio_unitario).keyup(function(){
            console.log('entra qui');
            let precio_unitario = 0.00;

            precio_unitario = parseInt($('#'+$self.id_txt_precio_unitario).val())?parseInt($('#'+$self.id_txt_precio_unitario).val()):0.00;

            $self.precio_unitario = precio_unitario
            $self.actualizarMontos();
        });
    }

    actualizarMontos()
    {
        // this.cantidad = parseInt(detalle.cantidad);
        // this.precio_unitario = parseFloat(detalle.mto_precio_unitario).toFixed(2);
        this.precio_total = parseFloat((this.cantidad * this.precio_unitario)/1.00).toFixed(2);
        this.mto_valor_unitario = parseFloat(this.precio_unitario/(1+(this.porcentaje_igv/100))).toFixed(2);
        this.mto_valor_venta = parseFloat(this.mto_valor_unitario * this.cantidad).toFixed(2);
        this.mto_base_igv = parseFloat(this.precio_total/(1+(this.porcentaje_igv/100))).toFixed(2);
        // this.porcentaje_igv = detalle.porcentaje_igv;
        this.igv = this.mto_valor_venta* (this.porcentaje_igv/100);
        this.total_impuestos = this.igv;

        this.actualizarMontosUI();

        this.nota.actualizarMontos();
    }

    actualizarMontosUI()
    {
        $('#'+this.id_td_precio_total).text(this.precio_total);
    }


    obtenerHTML()
    {
        let nota_detalle_html = ``;
        let select_html = ``;
        let manejado_disabled = ``;
        if(this.codigo_manejado == 1) manejado_disabled += 'disabled = true'
        select_html += `<option value="1" ${this.tipo_producto==1?'selected':''} >Producto</option>`;
        select_html += `<option value="2" ${this.tipo_producto==2?'selected':''} >Servicio</option>`;
        
        nota_detalle_html+= `
                        <tr id="${this.id_tr_nota_detalle}">
                            <td><select ${manejado_disabled}> `+select_html+` </select></td>
                            <td><input id="${this.id_txt_descripcion}" ${manejado_disabled} value="${this.descripcion}" style="width:100%"> </td>
                            <td class="text-center" ><input id="${this.id_txt_cantidad}"  value="${this.cantidad}" style="width:50%" class="text-right">  </td>
                            <td class="text-center" ><input id="${this.id_txt_precio_unitario}"  value="${this.precio_unitario}" style="width:60%" class="text-right"></td>
                            <td class="text-right" id="${this.id_td_precio_total}" >${this.precio_total}</td>
                            <td class="text-center"><i id="${this.id_icon_remove}"  class="fa fa-trash" style="color:red;cursor:pointer" role="button"></i> </td>
                        </tr>
                    `;
        return nota_detalle_html;
    }

    eliminar()
    {   
        $('#'+this.id_tr_nota_detalle).remove();
        this.nota.eliminarNotaDetalle(this);
    }

    toJSON()
    {
        let this_json = {
            cod_producto : this.cod_producto,
            unidad : this.unidad,
            descripcion : this.descripcion,
            cantidad : this.cantidad,
            mto_valor_unitario : this.mto_valor_unitario,
            mto_valor_venta : this.mto_valor_venta,
            mto_base_igv : this.mto_base_igv,
            porcentaje_igv : this.porcentaje_igv,
            mto_precio_unitario : this.precio_unitario,
            tip_afe_igv : this.tip_afe_igv,
            total_impuestos : this.total_impuestos,
            igv : this.igv
        };
        
        return this_json;
    }

}

// Clase nota
class Nota {
    constructor(desde_busqueda = 0, id = 0, nota = null) {

        var $self = this;
        //Initalize UI controls
        if(desde_busqueda == 0 )
        {   
            this.table = $('#table-detalle-comprobante');
            this.table.find('tbody').empty();
            
            this.subtotal_nota_txt = $('#subtotal_nota');
            this.igv_nota_txt = $('#igv_nota');
            this.total_nota_txt = $('#total_nota');

            this.btn_buscar = $('#btn_buscar_comprobante');
            this.formulario_buscar = $('#frm-buscar-comprobante');
            this.documento_input = $('#documento');
            this.documento_input.val('');
            
            this.btn_crear_nota = $('#btn_enviar_nota');

            this.select_motivo_nota = $('#motivo_nota');
            this.select_motivo_nota.val('');

            this.sustento_txt = $('#sustento');
            this.sustento_txt.val('');
            
            this.div_datos_comprobante = $('#div_datos_comprobante');
            this.div_datos_comprobante = $('#div_datos_comprobante').css('display','none');
            
            this.btn_nueva_fila = $('#btn_nueva_fila');

            this.div_mensaje_respuesta = $('#div_mensaje_respuesta');
            this.div_mensaje_respuesta.find('.loader').remove();
            this.div_mensaje_respuesta.find('#estado_resumen').empty();
            this.div_mensaje_respuesta.find('#mensaje_sunat').empty();
            this.div_mensaje_respuesta.css('display','none');

            this.div_busqueda_mensaje = $('#div_busqueda_mensaje');
            this.div_busqueda_mensaje.css('display','none');

            this.valor_venta = parseFloat(0.00).toFixed(2);
            this.igv = parseFloat(0.00).toFixed(2);
            this.precio_venta = parseFloat(0.00).toFixed(2);
            this.porcentaje_igv = parseFloat(0.00).toFixed(2);

            this.actualizarMontosUI();
            // Events binding
            this.formulario_buscar.off('click').on('submit',function(e){
                e.preventDefault();
                $self.buscarComprobante();
            });

            this.btn_crear_nota.off('click').on('click',function(){
                console.log('entra aqui');
                $self.crearNotaDeCredito();
            });

            this.select_motivo_nota.off('click').on('change',function(){
                $self.id_motivo = this.value;
            });

            this.documento_input.autocomplete({
                delay: 1,
                autoFocus: true,
                source: function (request, response) {
                    $.ajax({
                        url: 'ListarFolios',
                        type: "post",
                        dataType: "json",
                        dataSrc:'',   
                        headers:{
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            criterio: request.term
                        },
                        success: function (data) {
                            console.log(data);
                            response($.map(data, function (item) {
                                return {
                                    id: item.id_venta,
                                    folio: item.folio
                                }
                            }))
                        }
                    })
                },
                select: function (e, ui) {
            
                    /* Validar si cumple años el cliente */
                    e.preventDefault();
                    // var cumple = moment(ui.item.fecha_n).format('D MMMM');
                    // $("#cliente_id").val(ui.item.id);
                    $self.documento_input.val(ui.item.folio);
                
                },
                change: function() {
                    //$("#cliente_nombre").val('');
                    $self.documento_input.focus();
                    if($self.documento_input.val()=='')
                        $self.documento_input.val()="";
                    // console.log($("#cliente_nombre").val());
                }
            })
            .autocomplete( "instance" )._renderItem = function( ul, item ) {
                ul.css('z-index','10000');
                return $( "<li>" )
                .append(item.folio)
                .appendTo( ul );
            };

            this.btn_nueva_fila.on('click',function(e){
                e.preventDefault();
                $self.añadirNuevoDetalleFila();
            });

        }
        else if(desde_busqueda == 1)
        {   
            this.id = id;
            this.id_nota = nota.IdNota;
            this.id_tr_nota = ''+id+'_tr_nota';
            this.documento = nota.Serie+'-'+nota.Correlativo;
            this.fecha_emision= nota.FechaEmision;
            this.doc_afectado = nota.NumDocAfectado;
            this.id_estado_comprobante = nota.IdEstadoComprobante;
            this.desc_estado_comprobante = nota.DescEstadoComprobante;

            this.estado = this.determinarEstado();
            this.mensaje_sunat =nota.MensajeSunat?nota.MensajeSunat:'';
            // this.visualizar = '';
            $('#table-nota-cred-comprobante tbody').append(this.obtenerHTMLTabla());
        }
    }

    determinarEstado()
    {
        let estado = {};
        estado.descripcion = this.desc_estado_comprobante;
        
        switch(this.id_estado_comprobante)
        {
            case '1': {                
                estado.accion_a_tomar= ` <a id="${this.id_btn_firmar_xml}" href="#" class="card" style="background-color:#10A51F;padding:2px;color:white;opacity:1;"> Firmar </label>`;
                estado.color = '#1FBDB7';
                break;
            }
            case '2' || '5' : {
                estado.accion_a_tomar= `<a id="${this.id_btn_enviar_sunat}"  class="card" style="background-color:#1FBDB7;padding:2px;color:white;opacity:1;"> Enviar  </a>`;
                estado.color = '#10A51F';
                break;
            }
            case '3' : {
                estado.accion_a_tomar= ` <a id="${this.id_btn_estado}" href="#" class="card" style="background-color:#3F6B89;padding:2px;color:white;opacity:1;">Estado  </label>`;
                estado.color = '#3F6B89';
                break;
            }
            case '4' : {
                estado.accion_a_tomar= `<a id="${this.id_btn_baja}" href="#" class="card" style="background-color:#BB0808;padding:2px;color:white;opacity:1;"> Baja  </label>`;
                estado.color = '#BB0808';
                break;
            }
            case '5' : {
                estado.accion_a_tomar= `<a id="${this.id_btn_enviar_sunat}"   href="#" class="card" style="background-color:#2EBC3C;padding:2px;color:white;opacity:1;">Enviar </label>`;
                estado.color = '#2EBC3C';
                break;
            }
            default : estado.accion_a_tomar= ``;break;
        }   

        return estado;
    }

    obtenerHTMLTabla()
    {
        let nota_html = ``;
        nota_html += `
                    <tr id="${this.id_tr_nota}">
                        <td>${this.documento}</td>
                        <td>${this.fecha_emision}</td>
                        <td>${this.doc_afectado}</td>
                        <td class="text-center"><label class="card" style="background-color:${this.estado.color};padding:2px;color:white;opacity:1;" > ${this.estado.descripcion}</label> </td>
                        <td>${this.mensaje_sunat}</td>
                        <td class="text-center"><a href="#" class="card" style="background-color:#247BA0;padding:2px;color:white;opacity:1;">Ver </label></td>
                    </tr>
                        `;
        return nota_html;
    }

    actualizarDatosComprobante(cpe)
    {
        this.id_comprobante = cpe.id_venta;
        this.valor_venta = parseFloat(cpe.valor_venta).toFixed(2);
        this.igv = parseFloat(cpe.mto_igv).toFixed(2);
        this.precio_venta = parseFloat(cpe.mto_imp_venta).toFixed(2);
        this.porcentaje_igv = parseFloat(cpe.porcentaje_igv).toFixed(2);
        this.nombre_cliente = cpe.nombre_cliente;
        this.folio = cpe.folio;

        // this.sustento = '';

        
        this.detalles =[];
        this.doc_afectado = {};
        this.doc_afectado.numero = cpe.folio;
        this.doc_afectado.cliente = cpe.nombre_cliente;

        this.actualizarMontosUI();


        this.div_datos_comprobante = $('#div_datos_comprobante').css('display','block');
        this.div_datos_comprobante.find('#folio_dc').text(this.folio);
        this.div_datos_comprobante.find('#cliente_dc').text(this.nombre_cliente);
        this.div_datos_comprobante.find('#total_dc').text('S/. '+this.precio_venta);
    }

    actualizarMontosUI()
    {
        this.subtotal_nota_txt.text('S/. '+this.valor_venta);
        this.igv_nota_txt.text('S/. '+this.igv);
        this.total_nota_txt.text('S/. '+this.precio_venta);
    }
    
    buscarComprobante() 
    {   
        var $self = this;
        this.div_busqueda_mensaje.css('display','none');
        this.btn_buscar.prop('disabled',true);
        this.btn_buscar.val('Buscando..');
        this.table.find('tbody').empty();
        this.div_datos_comprobante = $('#div_datos_comprobante').css('display','none');
        this.detalles= [];
        this.actualizarMontos();
        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url:'ObtenerComprobanteYDetalles',
            data:{
                folio: this.documento_input.val()
            },
            headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success:function(respuesta)
            {
                $self.table.find('tbody').empty();
                    
                $self.btn_buscar.prop('disabled',false);
                $self.btn_buscar.val('Buscar');

                if(respuesta.code == 1)
                {
                    let comprobante = respuesta.comprobante;
                   
                    $self.actualizarDatosComprobante(comprobante);
                    let cont = 0;
                    comprobante.detalles.forEach(detalle => {
                        cont++;
                        detalle.tipo_producto = 1;
                        $self.detalles.push( new NotaDetalle(cont,detalle,$self.table,1,$self));
                    });
                    
                    $self.detalles.forEach(nota_detalle => {
                        $self.table.find('tbody').append(nota_detalle.obtenerHTML());
                        nota.bindComponents();
                    });
                }
                else if(respuesta.code == 0)
                {
                    $self.div_busqueda_mensaje.css('display','block');
                    $self.div_busqueda_mensaje.find('#label_error').text(respuesta.label_error);
                    $self.div_busqueda_mensaje.find('#mensaje_error').text(respuesta.mensaje_error);

                }

              

            }
        });
    }

    añadirNuevoDetalleFila()
    {
        let $self = this;
        let detalle_nuevo = {
            descripcion : 'Nueva linea',
            cantidad : parseInt(1),
            mto_precio_unitario : parseFloat(0.00).toFixed(2),
            // this.precio_total : parseFloat((this.cantidad * this.precio_unitario)/1.00).toFixed(2),
            mto_valor_unitario : parseFloat(0.00).toFixed(2),
            mto_valor_venta : parseFloat(0.00).toFixed(2),
            mto_base_igv : parseFloat(0.00).toFixed(2),
            cod_producto : 'NDC'+'_'+$self.detalles.length,
            porcentaje_igv : parseFloat($('#igv_txt').val()).toFixed(2) ,
            igv : 0.00,
            tip_afe_igv : '10',
            total_impuestos : 0.00,
            // Es producto o servicio, NIU para productos, ZZ para servicios.
            tipo_producto  : 1,
            // if(this.tipo_producto :: 1) this.unidad : 'NIU', else this.unidad : 'ZZ',
        }

        let nota_detalle = new NotaDetalle(this.detalles.length+1,detalle_nuevo,$self.table,2,$self);
        this.detalles.push(nota_detalle);

        this.table.find('tbody').append(nota_detalle.obtenerHTML());
        nota_detalle.bindComponents()
    }
    
    toJSON()
    {
        let detalles = [];
        if(this.detalles)
        {
            if(this.detalles.length> 0)
            this.detalles.forEach(nota => {
                detalles.push(nota.toJSON());
            });
        }
            

        console.log('invoco to JSON');
        var this_json = {
            id_tipo_nota_credito: this.id_tipo_nota_credito,
            id_comprobante : this.id_comprobante,
            id_motivo : this.id_motivo,
            valor_venta : this.valor_venta,
            igv :this.igv,
            precio_venta :this.precio_venta,
            sustento: this.sustento,
            detalles: detalles
            

        };
        console.log('termino to JSON',this_json);
     

        return this_json;
    }

    actualizarMontos()
    {
        console.log('entra actualizarMontos ');
        let sum_total = 0.00;
        let sum_igv = 0.00;
        let sum_subtotal = 0.00;
        
        if(this.detalles)
        {
            this.detalles.forEach(detalle => {
                sum_total+= parseFloat(detalle.precio_total);
                sum_igv += parseFloat(detalle.igv);
                sum_subtotal += parseFloat(detalle.mto_valor_venta);
            });    
        }

        this.valor_venta = parseFloat(sum_subtotal).toFixed(2);
        this.igv = parseFloat(sum_igv).toFixed(2);
        this.precio_venta = parseFloat(sum_total).toFixed(2);

        this.actualizarMontosUI()
    }

    crearNotaDeCredito()    
    {
        console.log('entra aqui tambien crear nota');
        var $self = this;

        this.validarCampos();

        this.div_mensaje_respuesta.find('.loader').remove();
        this.div_mensaje_respuesta.find('#estado_resumen').empty();
        this.div_mensaje_respuesta.find('#mensaje_sunat').empty();

        let loader = $('<div>');
        loader.addClass('loader');
        loader.css('margin-top','20px');
        this.div_mensaje_respuesta.append(loader);
        this.div_mensaje_respuesta.css('display','block');

        $.ajax({
            type:'POST',
            dataType:'JSON',
            url:'credito/RegistrarNotaCredito',
            data:{
                nota: $self.toJSON()
            },
            headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success:function(respuesta)
            {
                loader.remove();
                if(respuesta.code == 1)
                {
                    $self.div_mensaje_respuesta.find('#estado_resumen').text('Nota de crédito aceptada');
                    $self.div_mensaje_respuesta.removeClass('border-warning');
                    $self.div_mensaje_respuesta.addClass('border-info');
                    $self.resetNota();
                }
                else
                {
                    $self.div_mensaje_respuesta.find('#estado_resumen').text('No se pudo completar la entrega');
                    $self.div_mensaje_respuesta.removeClass('border-info');
                    $self.div_mensaje_respuesta.addClass('border-warning');
                }
                $self.div_mensaje_respuesta.find('#mensaje_sunat').text(respuesta.mensaje);
            }
        });
    }

    eliminarNotaDetalle(nota_detalle)
    {
        this.detalles.splice(this.detalles.indexOf(nota_detalle),1);
        this.actualizarMontos();
    }

    validarCampos()
    {
        this.sustento = this.sustento_txt.val();
    }

    resetNota()
    {
        this.select_motivo_nota.val('');
        this.sustento_txt.val('');
        this.documento_input.val('');

        this.div_datos_comprobante = $('#div_datos_comprobante').css('display','none');

        for(var i = this.detalles.length- 1; i>= 0; i--)
        {
            // console.log(docs_resumen.find(p=> p.identificador == id_boletas[i]));
            let nota_detalle  =  this.detalles[i];
            nota_detalle.eliminar();
        }
    }
}

var notas_list = [];
//Empieza todas las funciones
$(function () {

});

function nueva_nota() {
    //Abrir el modal
    $('#mdl-nueva-nota-cred').modal('show');

    nota = new Nota();
}

$('#frm-buscar-notas').on('submit',function(e){

    e.preventDefault();
    e.stopImmediatePropagation();

    let form = $(e.target);
    let parametros = form.serializeArray();
    console.log(parametros);
   
    obtenerNotas(parametros);
});

function obtenerNotas(obj_param)
{
    $('#btn-consultar').text('CONSULTANDO..');
    $('#btn-consultar').prop('disabled',true);
   
    $('#table-nota-cred-comprobante tbody').empty();
    $.ajax({
        type : 'POST',
        dataType: 'JSON',
        url: 'credito/BuscarNotasCred',
        data: obj_param,
        headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function(notas){
            $('#btn-consultar').text('CONSULTAR');
            $('#btn-consultar').prop('disabled',false);
            
            let notas_html = ``;
            // console.log(facturas);
           
            let cont = 0;
            notas_list = [];
            notas.forEach(nota => {
                cont++;
                notas_list.push(new Nota(1,cont,nota));
            });
        }
    });
}

$('#documento_folio').autocomplete({
    delay: 1,
    autoFocus: true,
    source: function (request, response) {
        $.ajax({
            url: 'credito/ListarFoliosNotaCredito',
            type: "post",
            dataType: "json",
            dataSrc:'',   
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                criterio: request.term
            },
            success: function (data) {
                console.log(data);
                response($.map(data, function (item) {
                    return {
                        id: item.IdNota,
                        folio: item.Folio
                    }
                }))
            }
        })
    },
    select: function (e, ui) {

        /* Validar si cumple años el cliente */
        e.preventDefault();
        // var cumple = moment(ui.item.fecha_n).format('D MMMM');
        // $("#cliente_id").val(ui.item.id);
        $('#documento_folio').val(ui.item.folio);
    
    },
    change: function() {
        //$("#cliente_nombre").val('');
        $('#documento_folio').focus();
        if($('#documento_folio').val()=='')
            $('#documento_folio').val()="";
        // console.log($("#cliente_nombre").val());
    }
})
.autocomplete( "instance" )._renderItem = function( ul, item ) {
    ul.css('z-index','10000');
    return $( "<li>" )
    .append(item.folio)
    .appendTo( ul );
};