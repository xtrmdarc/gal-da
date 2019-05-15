class Resumen 
{
    constructor(id,resumen)
    {
        var $self = this;
        this.id = id;
        this.docs_resumen =[];

        this.actualizarDatosFromResumen(resumen);

        this.id_tr_resumen = ''+this.id+this.id_resumen+'_tr_resumen'; 
        this.id_td_accion = ''+this.id+this.id_resumen+'_td_accion';
        this.id_td_estado = ''+this.id+this.id_resumen+'_td_estado';
        this.id_td_mensaje = ''+this.id+this.id_resumen+'_td_mensaje';

        $('#table-resumen-comprobante tbody').append(this.obtenerHtml());

        // $('#'+this.id_btn_estado).on('click',function(){
        //     abrirModalResumenEstado($self);
        // });

        // $('#'+this.id_btn_eliminar).on('click',function(){
        //     eliminarResumen();
        // });
        console.log('se crea el resumen');
        this.bindButtonListeners();

    }

    bindButtonListeners()
    {
        let $self = this;
        $('#'+this.id_btn_estado).off('click').on('click',function(){
            $self.abrirModalResumenEstado();
        });

        $('#'+this.id_btn_eliminar).off('click').on('click',function(){
            $self.eliminarResumen();
        });

        $('#'+this.id_btn_reenviar_resumen).off('click').on('click',function(){
            $self.reenviarResumen();
        });
    }

    abrirModalResumenEstado()
    {
        
        let resumen = this;
        console.log(resumen);
        $('#mdl_estado').empty();
        $('#mdl_resumen_id').text(resumen.name_xml_file);
        $('#mdl_fecha_resumen').text(resumen.fecha_resumen);
        $('#mdl_fecha_comprobantes').text(resumen.fecha_comprobantes);
        $('#mdl_estado').text(resumen.estado.descripcion);
        $('#mdl_mensaje_sunat').text(resumen.mensaje_sunat);
        
        if(resumen.estado.id == 3)
        {
            $('#mdl_estado').empty();
            resumen.consultarEstado();
        }
        
        resumen.actualizarAcciones();
        
        // $('#mdl_acciones').empty();
        // resumen.estado.acciones.forEach(accion => {
        //     $('#mdl_acciones').append(`<div class="col text-center"  > ${accion}</div>`);
        // });

        $('#mdl-estado-resumen').modal('show');
        resumen.buscarDocsResumenPorIdResumen();

        
        //Aqui colocar los documentos resumen asociados
    }

    buscarDocsResumenPorIdResumen()
    {
        let $self = this;
        var loader = $('<div>');
        loader.toggleClass('loader');
        loader.css('margin-left','auto');
        loader.css('margin-right','auto');

        $('#table_docs_resumen_estado tbody').empty();
        $('#table_docs_resumen_estado').after(loader);

        $.ajax({
            type:'POST',
            dataType:'JSON',
            url:'resumen/BuscarDocsResumenPorIdResumen',
            data:{
                id_resumen : $self.id_resumen
            },
            headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success:function(docsResumen)
            {   
                console.log(docsResumen);
                loader.remove();
                loader.remove();
                let cont = 0;
                docsResumen.forEach(doc => {
                    cont++;
                    $self.docs_resumen.push(new DocResumen(cont,doc));
                });
            }
        });
    }

    eliminarResumen()
    {
        var loader = $('<div>');
        loader.toggleClass('loader');
        loader.css('margin','0px');
        // loader.append('   Consultando');
        $('#mdl_estado').empty();
        $('#mdl_estado').append(loader);
        var $self = this;
        $.ajax({
            type: 'POST',
            dataType:'JSON',
            url:'resumen/EliminarResumen',
            data:{
                id_resumen :$self.id_resumen
            },
            headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success:function(resumen)
            {
                loader.remove();
                $this.actualizarDatosFromResumen(resumen);
                $this.actualizarEstadoTd();
                $this.actualizarAcciones();
                
            }
        });
    }

    actualizarDatosFromResumen(resumen)
    {
        this.codigo_sunat = resumen.codigo_sunat;
        this.fecha_comprobantes = resumen.fecha_comprobantes;
        this.fecha_resumen = resumen.fecha_resumen;
        this.id_empresa = resumen.id_empresa;
        this.id_resumen = resumen.id_resumen;
        this.mensaje_sunat = resumen.mensaje_sunat;
        this.name_xml_file = resumen.name_xml_file;
        this.path_xml_file = resumen.path_xml_file;

        this.id_btn_enviar_sunat = ''+this.id+this.id_resumen+'_btn_enviar';
        this.id_btn_firmar_xml = ''+this.id+this.id_resumen+'_btn_firmar';
        this.id_btn_estado = ''+this.id+this.id_resumen+'_btn_estado';
        this.id_btn_baja = ''+this.id+this.id_resumen+'_btn_baja';
        this.id_btn_eliminar = ''+this.id+this.id_resumen+'_btn_eliminar';
        this.id_btn_reenviar_resumen =''+this.id+this.id_resumen+'_btn_reenviar';

        this.desc_estado_comprobante = resumen.desc_estado_comprobante;
        this.id_estado_comprobante = resumen.id_estado_comprobante;
        this.estado = this.determinarEstado();
        
    }

    determinarEstado()
    {
        let estado = {};
        estado.descripcion = this.desc_estado_comprobante;
        estado.id = this.id_estado_comprobante;
        estado.acciones = [];
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
                estado.color = '#2EBC3C';
                break;
            }
            case '5' : {
                estado.acciones.push(`<a id="${this.id_btn_eliminar}"   href="#" class="card" style="background-color:#BB0808;padding:2px;color:white;opacity:1;">Eliminar </label>`);
                estado.acciones.push(`<a id="${this.id_btn_reenviar_resumen}"   href="#" class="card" style="background-color:#2EBC3C;padding:2px;color:white;opacity:1;">Re enviar </label>`);
                estado.accion_a_tomar= `<a id="${this.id_btn_enviar_sunat}"   href="#" class="card" style="background-color:#2EBC3C;padding:2px;color:white;opacity:1;">Enviar </label>`;
                estado.color = '#BB0808';
                break;
            }
            case '6' :{
                estado.color = '#BB0808';
            }
            default : estado.accion_a_tomar= ``;break;
        }   
        estado.accion_a_tomar= ` <a id="${this.id_btn_estado}" class="card" style="background-color:#3F6B89;padding:2px;color:white;opacity:1;">Estado  </label>`;
        estado.elementoHTML = `<label class="card" style="background-color:${estado.color};padding:2px;color:white;opacity:1;" > ${estado.descripcion}</label>`;
        return estado;
    }

    obtenerHtml()
    {
        let resumenHtml = ``;
        resumenHtml += `
                    <tr id="${this.id_tr_resumen}">
                        <td id="">${this.name_xml_file}</td>
                        <td id="">${this.fecha_comprobantes}</td>
                        <td id="">${this.fecha_resumen}</td>
                        <td id="${this.id_td_estado}" class="text-center">${this.estado.elementoHTML}</td>
                        <td id="${this.id_td_mensaje}" style="max-width:200px;white-space: nowrap; text-overflow:ellipsis; overflow: hidden;">${this.mensaje_sunat}</td>
                        <td id="${this.id_td_accion}" class="text-center">${this.estado.accion_a_tomar}</td>
                    </tr>
                    `;
        return resumenHtml;
    }

    actualizarEstadoTd()
    {
        $('#'+this.id_td_estado).empty();
        $('#'+this.id_td_estado).append(this.estado.elementoHTML);
        $('#mdl_estado').empty();
        $('#mdl_estado').append(this.estado.descripcion);
    }

    actualizarAcciones()
    {   
        $('#mdl_acciones').empty();
        this.estado.acciones.forEach(accion => {
            $('#mdl_acciones').append(`<div class="col text-center"> ${accion}</div>`);
        });
        this.bindButtonListeners();
    }

    actualizarMensajeSunat()
    {
        $('#'+this.id_td_mensaje).empty();
        $('#'+this.id_td_mensaje).append(this.mensaje_sunat);
        $('#mdl_mensaje_sunat').empty();
        $('#mdl_mensaje_sunat').append(this.mensaje_sunat);
    }

    consultarEstado()
    {
        var loader = $('<div>');
        loader.toggleClass('loader');
        loader.css('margin','0px');
        loader.append('   Consultando');
        $('#mdl_estado').append(loader);
        var $self = this;
        $.ajax({
            type:'POST',
            dataType: 'JSON',
            url: 'resumen/ConsultarEstado',
            data: {
                id_resumen : $self.id_resumen
            },
            headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success:function(resumen)
            {   
                // console.log(resumen);
                // console.log($self);
                // console.log('llega aqui pero no remueve el loader');
                loader.remove();
                $self.actualizarDatosFromResumen(resumen);
                $self.actualizarEstadoTd();
                $self.actualizarAcciones();
            }
        });
    }

    reenviarResumen()
    {
        var loader = $('<div>');
        loader.toggleClass('loader');
        loader.css('margin','0px');
        
        $('#mdl_estado').empty();
        $('#mdl_estado').append(loader);
        var $self = this;
        $.ajax({
            type:'POST',
            dataType:'JSON',
            url:'resumen/ReenviarResumen',
            data:{
                id_resumen: $self.id_resumen
            },
            headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success:function(resumen)
            {
                loader.remove();
                loader.remove();
                $self.actualizarDatosFromResumen(resumen);
                $self.actualizarEstadoTd();
                $self.actualizarAcciones();

            }
        });
    }

}

class DocResumen
{
    constructor(cont,doc_resumen) 
    {
        let $self = this;
        //datos
        this.id = cont;
        this.identificador = doc_resumen.id_venta; 
        this.id_tipo_doc = doc_resumen.id_tipo_doc;
        this.serie = doc_resumen.serie;
        this.correlativo = doc_resumen.correlativo;
        this.total = doc_resumen.total;
        this.desc_doc = doc_resumen.descripcion_documento;
        this.desc_estado = doc_resumen.descripcion_estado;
        this.id_estado_comprobante = doc_resumen.id_estado_comprobante;
        this.fecha_emision = doc_resumen.fecha_emision;
        this.incluido = true;

        this.id_cbox_incluye = ''+this.id+this.identificador+'_cbox_docresumen'; 
        this.id_tr_doc = ''+this.id+this.identificador+'_tr';
        let doc_resumen_html = ``;

        doc_resumen_html+= `
                        <tr id="${this.id_tr_doc}">
                            <td> <input id="${this.id_cbox_incluye}" type="checkbox" name="cbox_inlcuye_docresumen" checked >  </td>
                            <td>${this.fecha_emision} </td>
                            <td>${this.serie} </td>
                            <td>${this.correlativo} </td>
                            <td>${this.desc_doc} </td>
                            <td> ${this.total} </td>
                        </tr>
                            `;
        
        $('#table_docs_resumen tbody').append(doc_resumen_html);

        // Could be asked if docresumen is for estado table or no
        this.appendToResumenEstado();

        //Add event handlers

        $('#'+this.id_cbox_incluye).change(function(){
            $self.incluido = this.checked;
        });
    }

    appendToResumenEstado()
    {
        let doc_resumen_estado_html = ``;
        doc_resumen_estado_html += `
                <tr id="${this.id_tr_doc}">
                    <td>${this.serie} </td>
                    <td>${this.correlativo} </td>
                    <td>${this.desc_doc} </td>
                    <td>${this.total} </td>
                </tr>
        `;

        $('#table_docs_resumen_estado tbody').append(doc_resumen_estado_html);
    }

    eliminar()
    {
        $('#'+this.id_tr_doc).remove();
    }

    checkIncluye()
    {

    }
}

var docs_resumen= [];
var resumenes_list =[];

$(function(){
    determinarComprobantesEnviar()
});

function determinarComprobantesEnviar()
{
    var loader = $('<div>');
    loader.addClass('loader');
    loader.css('margin-top','0px');
    $('#div_comprobantes_enviar').append(loader);
    $('#div_comprobantes_enviar').css('display','block');
    $.ajax({
        type:'POST',
        dataType: 'JSON',
        url:'resumen/ExisteComprobantesEnviar',
        data:{},
        headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function (data)
        {
            if(data == true)
            {   
                $('#div_comprobantes_enviar').css('display','block');
                $('#mensaje_ce').css('display','block');
            }
            else {
                $('#div_comprobantes_enviar').css('display','none');
                $('#mensaje_ce').css('display','none');
            }

            loader.remove();
        }
    });
}


$('#frm-buscar-resumenes').on('submit',function(e){

    e.preventDefault();
    e.stopImmediatePropagation();

    let form = $(e.target);
    let parametros = form.serializeArray();
    console.log(parametros);
   
    obtenerResumenes(parametros);


});

$('#frm-buscar-docs').on('submit',function(e){

    e.preventDefault();
    
    let form = $(e.target);
    let obj_param = form.serializeArray();
    console.log(obj_param);
    obtenerDocsResumen(obj_param);

});

function obtenerResumenes(obj_param)
{
    resumenes_list = [];
    $.ajax({
        type : 'POST',
        dataType: 'JSON',
        url: 'resumen/BuscarResumenes',
        data: obj_param,
        headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function(resumenes){
            // let boletas_html = ``;
            // console.log(boletas);
            $('#table-resumen-comprobante tbody').empty();
            let cont = 0;
            
            resumenes.forEach(resumen => {
                cont++;
                resumenes_list.push(new Resumen(cont,resumen));
            });
            
        }
    });

}

function obtenerDocsResumen(obj_param)
{
    $('#btn_buscar_docs').prop('disabled',true);
    $('#btn_buscar_docs').val('BUSCANDO...');
    $.ajax({
        type:'POST',
        dataType:'JSON',
        url:'resumen/BuscarDocsResumenPorFecha',
        data:obj_param,
        headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success:function(docs)
        {
            $('#btn_buscar_docs').prop('disabled',false);
            $('#btn_buscar_docs').val('BUSCAR'); 
            let docs_html = ``;
            let cont = 0;
            $('#table_docs_resumen tbody').empty();

            docs.forEach(doc => {
                cont++;
                docs_resumen.push(new DocResumen(cont,doc));
            });
        }   
    });

}

function nuevo_resumen()
{
    $('#div_mensaje_respuesta').css('display','none');
    $('#estado_resumen').text('');
    $('#mensaje_sunat').text('');
    $('#mdl-nuevo-resumen').modal('show');
    $('#table_docs_resumen tbody').empty();
}

function enviarResumen()
{
    // console.log(docs_resumen);
    // console.log(docs_resumen.find(p=>p.id_tipo_doc == '5'));

    var id_boletas = (docs_resumen.filter(p=>p.id_tipo_doc == '5' && p.incluido == true)).map(a=> a.identificador);
    var id_notas = (docs_resumen.filter(p=> (p.id_tipo_doc == '7' || p.id_tipo_doc == '8')  && p.incluido == true)).map(a=>a.identificador);
    console.log(id_boletas,id_notas,docs_resumen);
    // if(id_boletas.length < 1 && id_notas.length < 1) 
    // {
    //     $('#mensaje_sunat').text('Resumen vacío');
    //     $('#estado_resumen').text('No existen documentos asociados a este resumen.');
    // }
    $('#estado_resumen').text('');
    $('#mensaje_sunat').text('');
    var loader = $('<div>');
    loader.addClass('loader');
    loader.css('margin-top','0px');
    $('#div_mensaje_respuesta').append(loader);
    $('#div_mensaje_respuesta').css('display','block');
    $('#btn_enviar_resumen').prop('disabled',true);
    $.ajax({
        type:'POST',
        dataType:'JSON',
        url:'resumen/EnviarResumen',
        data:{
            id_boletas : id_boletas,
            id_notas : id_notas
        },
        headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success:function(respuesta){
            console.log(respuesta);
            $('#btn_enviar_resumen').prop('disabled',false);
            loader.remove();
            $('#mensaje_sunat').text(respuesta.mensaje);
            if(respuesta.cod == 0)
            {
                //El resumen ha sido rechazado
                $('#estado_resumen').text('No se pudo completar la entrega');
                
            }
            else if (respuesta.cod == 1)
            {
                //El resumen ha sido aceptado
                $('#estado_resumen').text('El resumen fue aceptado');
                for(var i = id_boletas.length- 1; i>= 0; i--)
                {
                    // console.log(docs_resumen.find(p=> p.identificador == id_boletas[i]));
                    let doc  =  docs_resumen.find(p=> p.identificador == id_boletas[i]);
                    doc.eliminar();
                    docs_resumen.splice(docs_resumen.indexOf(doc),1);
                    
                }
                    
                for(var i = id_notas.length- 1; i>= 0; i--)
                {
                    let doc = docs_resumen.find(p=> p.identificador == id_notas[i]);
                    doc.eliminar();
                    docs_resumen.splice(docs_resumen.indexOf(doc),1);
                    // console.log(  docs_resumen.find(p=> p.identificador == id_notas[i]));
                }
            }
            // $('#mdl-nuevo-resumen').modal('hide');
        }   
    })
}

