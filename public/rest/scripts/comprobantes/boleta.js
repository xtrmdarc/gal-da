//Declaracion de clases

class boleta {

    constructor(id,boleta){
        console.log(id,boleta);
        let boletas_html =``;
        var $self = this;
        this.id = id;
        this.id_estado_comprobante = boleta.id_estado_comprobante;
        this.desc_estado_comprobante = boleta.desc_estado_comprobante;
        this.id_venta = boleta.id_venta;
        this.mensaje_sunat = boleta.mensaje_sunat?boleta.mensaje_sunat:'';
        this.overlay_div;
        this.loader_div;
        
        // this.id_btn_enviar_sunat = ''+id+boleta.id_venta+'_btn_enviar';
        // this.id_btn_firmar_xml = ''+id+boleta.id_venta+'_btn_firmar';
        // this.id_btn_estado = ''+id+boleta.id_venta+'_btn_estado';
        // this.id_btn_baja = ''+id+boleta.id_venta+'_btn_baja';

        this.id_tr_boleta = ''+id+boleta.id_venta+'_tr_boleta';

        this.id_td_visualizar = ''+id+boleta.id_venta+'_td_visualizar';

        this.id_td_serie = ''+id+boleta.id_venta+'_td_serie';
        this.id_td_correlativo= ''+id+boleta.id_venta+'_td_correlativo';
        this.id_td_fecha_venta= ''+id+boleta.id_venta+'_td_fecha_venta';
        this.id_td_nombre_cliente= ''+id+boleta.id_venta+'_td_nombre_cliente';
        this.id_td_estado= ''+id+boleta.id_venta+'_td_estado';
        this.id_td_mensaje= ''+id+boleta.id_venta+'_td_mensaje';
        // this.id_td_accion= ''+id+boleta.id_venta+'_td_accion';

        this.estado = this.determinarEstado();
        
        // this.estado.color
        boletas_html += `
                        <tr id="${this.id_tr_boleta}" >
                            <td id="${this.id_td_serie}" >${boleta.serie}</td>
                            <td id="${this.id_td_correlativo}">${boleta.correlativo} </td>
                            <td id="${this.id_td_fecha_venta}">${boleta.fecha_venta} </td>
                            <td id="${this.id_td_nombre_cliente}">${boleta.nombre_cliente} </td>
                            <td id="${this.id_td_estado}" class="text-center" > <label class="card" style="background-color:${this.estado.color};padding:2px;color:white;opacity:1;" > ${this.desc_estado_comprobante}</label> </td>
                            <td id="${this.id_td_mensaje}" id="" >${this.mensaje_sunat} </td>
                            <td id="${this.id_td_visualizar}" class="text-center"> <a href="#" class="card" style="background-color:#247BA0;padding:2px;color:white;opacity:1;">Ver </label></td>
                        `;
                        // <td id="${this.id_td_accion}" class="text-center"> ${this.estado.accion_a_tomar} </td>
        
        boletas_html += ` 
                        </tr>
                        `;
        $('#table-boleta-comprobante tbody').append(boletas_html);

        // $('#'+this.id_btn_baja).on('click',function(){
           
        // });
        // $('#'+this.id_btn_enviar_sunat).on('click',function(){
        //     $self.enviarSunat();
        // });
        // $('#'+this.id_btn_estado).on('click',function(){
            
        // });
        // $('#'+this.id_btn_baja).on('click',function(){
            
        // });

    }

    determinarEstado(){
        
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
    }

    actualizarMensaje(){

        $('#'+this.id_td_mensaje).empty();
        let newMensaje = `${this.mensaje_sunat}`;
        $('#'+this.id_td_mensaje).append(newMensaje);
    }

    actualizarboletaDOM(){
        
    }

    actualizarCamposPorboleta(boleta){
        this.id_estado_comprobante = boleta.id_estado_comprobante;
        this.desc_estado_comprobante = boleta.desc_estado_comprobante;
        this.mensaje_sunat = boleta.mensaje_sunat?boleta.mensaje_sunat:'';
        this.id_venta = boleta.id_venta;
        this.estado = this.determinarEstado();
    }

    estadoCargando()
    {
        var tr_boleta =  $('#'+this.id_tr_boleta);
        tr_boleta.css({position:'relative'});
        
        this.overlay_div = $('<div>');
        this.overlay_div.toggleClass('div_overlay');
        this.overlay_div.toggleClass('text-center');
        this.loader_div = $('<div>');
        this.loader_div.toggleClass('loader');
        this.loader_div.css('margin-top','22px');

        this.overlay_div.append(this.loader_div);
        this.overlay_div.css({position:'absolute',left:tr_boleta.position().left,top:tr_boleta.position().top,height:tr_boleta.height()});

        $('#'+this.id_tr_boleta).append(this.overlay_div);
    }

    detenerCargando()
    {
        this.overlay_div.remove();
        this.loader_div.remove();
    }


    firmar(){

    }


}

// var boleta = [];
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
}).autocomplete( "instance" )._renderItem = function( ul, item ) {
    return $( "<li>" )
      .append(item.nombres)
      .appendTo( ul );
  };


$('#frm-buscar-boletas').on('submit',function(e){

    e.preventDefault();
    e.stopImmediatePropagation();

    let form = $(e.target);
    let parametros = form.serializeArray();
    console.log(parametros);
   
    obtenerBoletas(parametros);


});

function obtenerBoletas(obj_param)
{

    $.ajax({
        type : 'POST',
        dataType: 'JSON',
        url: 'boleta/BuscarBoletas',
        data: obj_param,
        headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function(boletas){

            let boletas_html = ``;
            // console.log(boletas);
            $('#table-boleta-comprobante tbody').empty();
            let cont = 0;
            boletas.forEach(bol => {
                cont++;
                boletas.push(new boleta(cont,bol));

            });
        
            
        }
    });

}
