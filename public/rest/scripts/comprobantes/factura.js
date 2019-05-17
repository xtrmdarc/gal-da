//Declaracion de clases

class factura {

    constructor(id,fact){
        console.log(id,fact);
        let facturas_html =``;
        var $self = this;
        this.id = id;
        this.id_estado_comprobante = fact.id_estado_comprobante;
        this.desc_estado_comprobante = fact.desc_estado_comprobante;
        this.id_venta = fact.id_venta;
        this.mensaje_sunat = fact.mensaje_sunat?fact.mensaje_sunat:'';
        this.overlay_div;
        this.loader_div;
        
        this.id_btn_enviar_sunat = ''+id+fact.id_venta+'_btn_enviar';
        this.id_btn_firmar_xml = ''+id+fact.id_venta+'_btn_firmar';
        this.id_btn_estado = ''+id+fact.id_venta+'_btn_estado';
        this.id_btn_baja = ''+id+fact.id_venta+'_btn_baja';

        this.id_tr_fact = ''+id+fact.id_venta+'_tr_fact';

        this.id_td_serie = ''+id+fact.id_venta+'_td_serie';
        this.id_td_correlativo= ''+id+fact.id_venta+'_td_correlativo';
        this.id_td_fecha_venta= ''+id+fact.id_venta+'_td_fecha_venta';
        this.id_td_nombre_cliente= ''+id+fact.id_venta+'_td_nombre_cliente';
        this.id_td_estado= ''+id+fact.id_venta+'_td_estado';
        this.id_td_mensaje= ''+id+fact.id_venta+'_td_mensaje';
        this.id_td_visualizar = ''+id+fact.id_venta+'_td_visualizar';
        this.id_td_accion= ''+id+fact.id_venta+'_td_accion';

        this.estado = this.determinarEstado();
        
        // this.estado.color
        facturas_html += `
                        <tr id="${this.id_tr_fact}" >
                            <td id="${this.id_td_serie}" >${fact.serie}</td>
                            <td id="${this.id_td_correlativo}">${fact.correlativo} </td>
                            <td id="${this.id_td_fecha_venta}">${fact.fecha_venta} </td>
                            <td id="${this.id_td_nombre_cliente}">${fact.nombre_cliente} </td>
                            <td id="${this.id_td_estado}" class="text-center" > <label class="card" style="background-color:${this.estado.color};padding:2px;color:white;opacity:1;" > ${this.desc_estado_comprobante}</label> </td>
                            <td id="${this.id_td_mensaje}" id="" >${this.mensaje_sunat} </td>
                            <td id="${this.id_td_visualizar}" class="text-center"> <a href="#" class="card" style="background-color:#247BA0;padding:2px;color:white;opacity:1;">Ver </label></td>
                            <td id="${this.id_td_accion}" class="text-center"> ${this.estado.accion_a_tomar} </td>
                        `;
        
        facturas_html += ` 
                        </tr>
                        `;

        $('#table-factura-comprobante tbody').append(facturas_html);

        this.bindEventsRow();

    }

    bindEventsRow()
    {   
        let $self = this;
        $('#'+this.id_btn_baja).off('click').on('click',function(){
           
        });
        $('#'+this.id_btn_enviar_sunat).off('click').on('click',function(){
            $self.enviarSunat();
        });
        $('#'+this.id_btn_estado).off('click').on('click',function(){
            
        });
        $('#'+this.id_btn_baja).off('click').on('click',function(){
            
        });
    }

    determinarEstado(){
        
        let estado = {};
        estado.descripcion = this.desc_estado_comprobante;
        
        switch(this.id_estado_comprobante)
        {
            case '1': {
                
                estado.accion_a_tomar= ` <a id="${this.id_btn_firmar_xml}" class="card" style="background-color:#10A51F;padding:2px;color:white;opacity:1;"> Firmar </label>`;
                estado.color = '#1FBDB7';
                break;
            }
            case '2'  : {
                estado.accion_a_tomar= `<a id="${this.id_btn_enviar_sunat}"  class="card" style="background-color:#1FBDB7;padding:2px;color:white;opacity:1;"> Enviar  </a>`;
                estado.color = '#10A51F';
                break;
            }
            // case '3' : {
            //     estado.accion_a_tomar= ` <a id="${this.id_btn_estado}" href="#" class="card" style="background-color:#3F6B89;padding:2px;color:white;opacity:1;">Estado  </label>`;
            //     estado.color = '#3F6B89';
            //     break;
            // }
            case '3' : {
                estado.accion_a_tomar= ` <a id="${this.id_btn_enviar_sunat}"  class="card" style="background-color:#1FBDB7;padding:2px;color:white;opacity:1;">Reenviar</label>`;
                estado.color = '#3F6B89';
                break;
            }
            case '4' : {
                estado.accion_a_tomar= `<a id="${this.id_btn_baja}"  class="card" style="background-color:#BB0808;padding:2px;color:white;opacity:1;"> Baja  </label>`;
                estado.color = '#BB0808';
                break;
            }
            case '5' : {
                estado.accion_a_tomar= `<a id="${this.id_btn_enviar_sunat}" class="card" style="background-color:#1FBDB7;padding:2px;color:white;opacity:1;">Reenviar</label>`;
                estado.color = '#2EBC3C';
                break;
            }
            default : estado.accion_a_tomar= ``;break;
        }   

        return estado;

    }

    actualizarEstado(){
        // let estado = this.determinarEstado();
        $('#'+this.id_td_estado).empty();
        let newEstado = `<label class="card" style="background-color:${this.estado.color};padding:2px;color:white;opacity:1;" > ${this.desc_estado_comprobante}</label>` ;
        $('#'+this.id_td_estado).append(newEstado);
    }

    actualizarAccion(){

        $('#'+this.id_td_accion).empty();
        let newAccion = `${this.estado.accion_a_tomar}`;
        $('#'+this.id_td_accion).append(newAccion);
        this.bindEventsRow();
    }

    actualizarMensaje(){

        $('#'+this.id_td_mensaje).empty();
        let newMensaje = `${this.mensaje_sunat}`;
        $('#'+this.id_td_mensaje).append(newMensaje);
    }

    actualizarFacturaDOM(){
        
    }

    actualizarCamposPorFact(fact){
        this.id_estado_comprobante = fact.id_estado_comprobante;
        this.desc_estado_comprobante = fact.desc_estado_comprobante;
        this.mensaje_sunat = fact.mensaje_sunat?fact.mensaje_sunat:'';
        this.id_venta = fact.id_venta;
        this.estado = this.determinarEstado();
    }

    estadoCargando()
    {
        var tr_fact =  $('#'+this.id_tr_fact);
        tr_fact.css({position:'relative'});
        
        this.overlay_div = $('<div>');
        this.overlay_div.toggleClass('div_overlay');
        this.overlay_div.toggleClass('text-center');
        this.loader_div = $('<div>');
        this.loader_div.toggleClass('loader');
        this.loader_div.css('margin-top','22px');

        this.overlay_div.append(this.loader_div);
        this.overlay_div.css({position:'absolute',left:tr_fact.position().left,top:tr_fact.position().top,height:tr_fact.height()});

        $('#'+this.id_tr_fact).append(this.overlay_div);
    }

    detenerCargando()
    {
        this.overlay_div.remove();
        this.loader_div.remove();
    }

    darBajaSunat(){
        
        $.ajax({
            type:'POST',
            dataType: 'JSON',
            url:'',
            data:{},
            headers:{},
            success:function(){

            }
        });

    }

    enviarSunat(){
        let $self = this;

        $self.estadoCargando();
       
        $.ajax({
            type:'POST',
            dataType :'JSON',
            url:'factura/EnviarFactura',
            data:{id_venta:$self.id_venta},
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(fact){
                // $self.td_serie.text('cambio y funciona esta pta mierda');
                //Actualizar la factura DOM
                console.log(fact);
                
                $self.actualizarCamposPorFact(fact);
                $self.actualizarAccion();
                $self.actualizarEstado();
                $self.actualizarMensaje();

                $self.detenerCargando();
            }
        });
    }



    firmar(){

    }


}

// var factuas = [];
$(function(){
    //Aqui empieza todo 

});


$("#cliente_nombre").autocomplete({
    delay: 1,
    autoFocus: true,
    source: function (request, response) {
        $.ajax({
            url: '/inicio/BuscarCliente',
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
                response($.map(data, function (item) {
                    return {

                        id: item.id_cliente,
                        dni: item.dni,
                        nombres: item.nombre,
                        fecha_n: item.fecha_nac
                    }
                }))
            }
        })
    },
    select: function (e, ui) {

        /* Validar si cumple años el cliente */
        e.preventDefault();
        console.log(ui.item);
        var cumple = moment(ui.item.fecha_n).format('D MMMM');
        $("#cliente_id").val(ui.item.id);
        $("#cliente_nombre").val(ui.item.nombres);
        console.log($("#cliente_nombre").val());
        // if(diactual == cumple){
        //     $("#hhb").addClass("mhb");
        // }
        //$(this).blur(); 
        console.log($("#cliente_nombre").val());

    },
    change: function() {
        //$("#cliente_nombre").val('');
        $("#cliente_nombre").focus();
        if($("#cliente_nombre").val()=='')
            $('#cliente_id').val()="";
        console.log($("#cliente_nombre").val());
    }
})
.autocomplete( "instance" )._renderItem = function( ul, item ) {
    return $( "<li>" )
      .append(item.nombres)
      .appendTo( ul );
  };


$('#frm-buscar-facturas').on('submit',function(e){

    e.preventDefault();
    e.stopImmediatePropagation();

    let form = $(e.target);
    let parametros = form.serializeArray();
    console.log(parametros);
   
    obtenerFacturas(parametros);


});
$('#btn_enviar').on('click',function(){
    alert('entra pero no funca los metodos');
  
});

function obtenerFacturas(obj_param)
{

    $.ajax({
        type : 'POST',
        dataType: 'JSON',
        url: 'factura/BuscarFacturas',
        data: obj_param,
        headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function(facturas){

            let facturas_html = ``;
            // console.log(facturas);
            $('#table-factura-comprobante tbody').empty();
            let cont = 0;
            facturas.forEach(fact => {
                cont++;
                facturas.push(new factura(cont,fact));

            });
        }
    });

}
