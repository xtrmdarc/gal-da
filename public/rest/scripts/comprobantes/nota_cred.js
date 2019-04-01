//Declaracion de clases
var nota;
// Clase nota_detalle
class NotaDetalle{

    constructor(id,detalle,tabla,codigo_manejado,nota) {
        console.log(detalle);
        this.codigo_manejado = codigo_manejado;
        this.nota = nota;
        this.id = id;
        if(codigo_manejado == 1)
        {
            
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
        }
        else
        {

        }

        this.id_tr_nota_detalle = ''+this.id+'_tr_nota_detalle';
        this.id_icon_remove = ''+this.id+'_icon_remove';
    }

    bindComponents()
    {
        let $self = this;
        $('#'+this.id_icon_remove).on('click',function(){
            $self.eliminar();
        });
    }

    obtenerHTML()
    {
        let nota_detalle_html = ``;
        let select_html = ``;
        let manejado_disabled = ``;
        if(this.codigo_manejado == 1) manejado_disabled += 'disabled = true'
        select_html += `<option value="" >Seleccionar</option>`;
        select_html += `<option value="1" ${this.tipo_producto==1?'selected':''} >Producto</option>`;
        select_html += `<option value="2" ${this.tipo_producto==2?'selected':''} >Servicio</option>`;
        
        nota_detalle_html+= `
                        <tr id="${this.id_tr_nota_detalle}">
                            <td><select ${manejado_disabled}> `+select_html+` </select></td>
                            <td>${this.descripcion}</td>
                            <td class="text-center">${this.cantidad}</td>
                            <td class="text-right">${this.precio_unitario}</td>
                            <td class="text-right">${this.precio_total}</td>
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
    constructor() {
        var $self = this;
        //Initalize UI controls
        this.table = $('#table-detalle-comprobante');
        this.table.find('tbody').empty();
        
        this.subtotal_nota_txt = $('#subtotal_nota');
        this.igv_nota_txt = $('#igv_nota');
        this.total_nota_txt = $('#total_nota');

        this.btn_buscar = $('#btn_buscar_comprobante');
        this.formulario_buscar = $('#frm-buscar-comprobante');
        this.documento_input = $('#documento');
        this.btn_crear_nota = $('#btn_enviar_nota');
        this.select_motivo_nota = $('#motivo_nota');
        this.sustento_txt = $('#sustento');

        this.div_datos_comprobante = $('#div_datos_comprobante');
        this.div_datos_comprobante = $('#div_datos_comprobante').css('display','none');


        this.div_mensaje_respuesta = $('#div_mensaje_respuesta');
        this.div_mensaje_respuesta.find('.loader').remove();
        this.div_mensaje_respuesta.find('#estado_resumen').empty();
        this.div_mensaje_respuesta.find('#mensaje_sunat').empty();
        this.div_mensaje_respuesta.css('display','none');

        this.valor_venta = parseFloat(0.00).toFixed(2);
        this.igv = parseFloat(0.00).toFixed(2);
        this.precio_venta = parseFloat(0.00).toFixed(2);
        this.porcentaje_igv = parseFloat(0.00).toFixed(2);

        this.actualizarMontosUI();

        this.formulario_buscar.on('submit',function(e){
            e.preventDefault();
            $self.buscarComprobante();
        });

        this.btn_crear_nota.on('click',function(){
            console.log('entra aqui');
            $self.crearNotaDeCredito();
        });

        this.select_motivo_nota.on('change',function(){
            $self.id_motivo = this.value;
        });

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
            success:function(comprobante)
            {
                console.log(comprobante);
                $self.btn_buscar.prop('disabled',false);
                $self.btn_buscar.val('Buscar');
                $self.actualizarDatosComprobante(comprobante);
                let cont = 0;
                comprobante.detalles.forEach(detalle => {
                    cont++;
                    detalle.tipo_producto = 1;
                    $self.detalles.push( new NotaDetalle(cont,detalle,$self.table,1,$self));
                });
                
                $self.detalles.forEach(nota => {
                    $self.table.find('tbody').append(nota.obtenerHTML());
                    nota.bindComponents();
                });

            }
        });
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
        let sum_total = 0.00;
        let sum_igv = 0.00;
        let sum_subtotal = 0.00;
        
        if(this.detalles)
        {
            this.detalles.forEach(detalle => {
                sum_total+= detalle.precio_total;
                sum_igv += detalle.igv;
                sum_subtotal += detalle.mto_valor_venta;
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
}


//Empieza todas las funciones
$(function () {

});

function nueva_nota() {
    //Abrir el modal
    $('#mdl-nueva-nota-cred').modal('show');
    nota = new Nota();

}