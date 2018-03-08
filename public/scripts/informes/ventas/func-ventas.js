$(function() {
    $('#informes').addClass("active");
    moment.locale('es');
    listar();

    $('#start').datetimepicker({
        format: 'DD-MM-YYYY LT',
        locale: 'es-do'
    });

    $('#end').datetimepicker({
        useCurrent: false,
        format: 'DD-MM-YYYY LT',
        locale: 'es-do'
    });
    
    $("#start").on("dp.change", function (e) {
        $('#end').data("DateTimePicker").minDate(e.date);
        listar();
    });

    $("#end").on("dp.change", function (e) {
        $('#start').data("DateTimePicker").maxDate(e.date);
        listar();
    });
});

$('#tipo_ped, #tipo_doc, #cod_cajas, #cliente').change( function() {
    listar();
});

var listar = function(){

    var moneda = $("#moneda").val();
    ifecha = $("#start").val();
    ffecha = $("#end").val();
    tped = $("#tipo_ped").selectpicker('val');
    tdoc = $("#tipo_doc").selectpicker('val');
    icaja = $('#cod_cajas').selectpicker('val');
    cliente = $('#cliente').selectpicker('val');

    var vsbt = 0,
        vigv = 0,
        v_des = 0,
        vtotal = 0;

    $.ajax({
        type: "POST",
        url: "?c=Informe&a=Datos",
        data: {
            ifecha: ifecha,
            ffecha: ffecha,
            tped: tped,
            tdoc: tdoc,
            icaja: icaja,
            cliente: cliente
        },
        dataType: "json",
        success: function(item){

            if (item.data.length != 0) {
                $.each(item.data, function(i, campo) {  
                    vtotal += parseFloat(campo.total);
                    vsbt += parseFloat(campo.total /  (1+parseFloat(campo.igv)));
                    vigv += parseFloat((campo.total / (1+parseFloat(campo.igv))) * campo.igv);
                    v_des += parseFloat(campo.descu);
                });
            }

            $('#des_v').text(moneda+' '+(v_des).toFixed(2));
            $('#total_v').text(moneda+' '+(vtotal).toFixed(2));
            $('#subt_v').text(moneda+' '+(vsbt).toFixed(2));
            $('#igv_v').text(moneda+' '+(vigv).toFixed(2));
        }
    });

    var table = $('#table')
    .DataTable({
        "destroy": true,
        "responsive": true,
        "dom": "tp",
        "bSort": false,
        "ajax":{
            "method": "POST",
            "url": "?c=Informe&a=Datos",
            "data": {
                ifecha: ifecha,
                ffecha: ffecha,
                tped: tped,
                tdoc: tdoc,
                icaja: icaja,
                cliente: cliente
            }
        },
        "columns":[
            {"data":"fec_ven","render": function ( data, type, row ) {
                return '<i class="fa fa-calendar"></i> '+moment(data).format('DD-MM-Y')+'<br><i class="fa fa-clock-o"></i> '
                +moment(data).format('h:mm A');
            }},
            {"data":"desc_caja","render": function ( data, type, row ) {
                return '<p class="mayus">'+data+'</p>';
            }},
            {"data":"Cliente.nombre","render": function ( data, type, row ) {
                return '<p class="mayus">'+data+'</p>';
            }},
            {
                "data": null,
                "render": function ( data, type, row) {
                    return data.desc_td+'<br>'+data.numero;
                }
            },
            {
                "data": null,
                "render": function ( data, type, row) {
                    var opc = data.id_tpag;
                    switch(opc){
                        case '1':
                            return '<p class="text-right"><strong>Efectivo('+moneda+'):</strong> '+data.pago_efe+'</p>';
                        break;
                        case '2':
                            return '<p class="text-right"><strong>Tarjeta('+moneda+'):</strong> '+data.pago_tar+'</p>';
                        break;
                        case '3':
                            return '<p class="text-right"><strong>Efectivo('+moneda+'):</strong> '+data.pago_efe+'<br>'
                            +'<strong>Tarjeta('+moneda+'):</strong> '+data.pago_tar+'</p>';
                        break;
                    }
                }
            },
            {"data":null,"render": function ( data, type, row) {
                switch(true){
                    case data.descu > 0:
                        return '<div class="text-right bold"> '+moneda+' '+data.total+'</div><p class="text-right">Dscto.: -'+data.descu+'</p>';
                    break;
                    default:
                        return '<p class="text-right bold"> '+moneda+' '+data.total+'</p>';
                    break;
                }
            }},
            {"data":null,"render": function ( data, type, row) {
                return 'Contado';
            }},
            {"data":"creator","render": function ( data, type, row ) {
                return '<p class="text-center"><span class="label label-primary">ACTIVO</span></p>';
            }},
            {"data":null,"render": function ( data, type, row ) {
                return '<p class="text-right"><a class="btn btn-sm btn-primary" onclick="detalle('+data.id_ven+',\''+data.desc_td+'\',\''+data.numero+'\')">Ver</a></p>';
            }}
        ]
    });
};

var detalle = function(cod,doc,num){
    var moneda = $("#moneda").val();
    $('#lista_p').empty();
    $('#detalle').modal('show');
    $('.title-d').text(doc+' - '+num);
    $.ajax({
      type: "post",
      dataType: "json",
      data: {
          cod: cod
      },
      url: '?c=Informe&a=Detalle',
      success: function (data){
        $.each(data, function(i, item) {
            var calc = item.precio * item.cantidad;
            $('#lista_p')
            .append(
              $('<tr/>')
                .append($('<td/>').html(item.cantidad))
                .append($('<td/>').html(item.Producto.nombre_prod+' <span class="label label-primary">'+item.Producto.pres_prod+'</span>'))
                .append($('<td/>').html(moneda+' '+item.precio))
                .append($('<td class="text-right"/>').html(moneda+' '+(calc).toFixed(2)))
                );
            });
        }
    });
};