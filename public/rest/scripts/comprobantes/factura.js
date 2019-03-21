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
            
            facturas.forEach(fact => {
                facturas_html += `
                                <tr>
                                    <td>${fact.serie}</td>
                                    <td>${fact.correlativo} </td>
                                    <td>${fact.fecha_venta} </td>
                                    <td>${fact.nombre_cliente} </td>
                                    <td>${fact.desc_estado_comprobante} </td>
                                    <td>${fact.mensaje_sunat} </td>
                                `;
                switch (fact.id_estado_comprobante)
                {
                    case 1 : facturas_html += `<td> Firmar </td>`;break;
                    case 2 : facturas_html += `<td> Enviar y Eliminar </td>`;break;
                    case 3 : facturas_html += `<td> Ver </td>`;break;
                    case 4 : facturas_html += `<td>  </td>`;break;
                    case 5 : facturas_html += `<td> </td>`;break;
                    default : facturas_html += `<td> </td>`;break;
                }
                facturas_html += ` 
                                </tr>
                                `;
            });
            $('#table-factura-comprobante tbody').empty();
            $('#table-factura-comprobante tbody').append(facturas_html);
            
        }
    });
}
