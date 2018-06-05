$(function() {  

    setupSocketio();
    datosGenerales();
    $('#tablero').addClass("active");

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
        datosGenerales();
    });
    
    $("#end").on("dp.change", function (e) {
        $('#start').data("DateTimePicker").maxDate(e.date);
        datosGenerales();
    });
})

var datosGenerales = function(){

ifecha = $("#start").val();
ffecha = $("#end").val();

$('#lista_platos').empty();
$('#lista_productos').empty();

$.ajax({
    type: "POST",
    url: "tablero/DatosGrls",
    data: {
            ifecha: ifecha,
            ffecha: ffecha
        },
    "dataSrc":"",  
    headers:{
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    dataType: "json",
    success: function(item){
       
        var moneda = $("#moneda").val();
        var totalVentas = (parseFloat(item['data1'][0].efe) - parseFloat(item['data1'][0].tar)).toFixed(2);
        var efectivoReal = (parseFloat(item['data1'][0].efe) + parseFloat(item['data13'][0].ting) - parseFloat(item['data2'][0].tgas)).toFixed(2);
        if(item['data1'][0].total_v != '0.00'){
        var efectivo = (parseFloat(item['data1'][0].efe) * 100 ) / parseFloat(totalVentas);
        var tarjeta = (parseFloat(item['data1'][0].tar) * 100 ) / parseFloat(totalVentas);
        //var meta = (parseFloat(totalVentas) * 100 ) / parseFloat(item['data13'][0].margen);
        } else { var efectivo = 0; var tarjeta = 0; var meta = 0; }
        if(item['data3'][0] != undefined){
        var pedidosPorcentaje = (parseFloat(item['data3'][0].tped) * 100 ) / parseFloat(item['data4'][0].toped);
        $('#mozo').text(item['data3'][0].nombres+' '+item['data3'][0].ape_paterno);
        $('#pedidos').text(item['data3'][0].tped+' pedido(s)');
        $('#t_ped').text((pedidosPorcentaje).toFixed(2));
        } else {$('#pedidos').text('0 pedido(s)'); $('#mozo').text('A la espera'); $('#t_ped').text('0.00'); }
        if(item['data6'][0].total_v != '0.00'){
        var totalVentasMesas = (parseFloat(item['data6'][0].total_v) / parseFloat(item['data5'][0].total));
        } else { var totalVentasMesas = 0; var totalVentasMostrador = 0; }
        if(item['data7'][0].total_v != '0.00'){
        var totalVentasMostrador = (parseFloat(item['data7'][0].total_v) / parseFloat(item['data8'][0].total));
        } else { var totalVentasMostrador = 0; }
        $('.efe').text(moneda+" "+item['data1'][0].efe);
        $('.tar').text(moneda+" "+item['data1'][0].tar);
        $('.des').text(moneda+" "+item['data1'][0].des);
        $('#ing').text(moneda+" "+item['data13'][0].ting);
        $('#gas').text(moneda+" "+item['data2'][0].tgas);
        $('.total_v').text(moneda+" "+totalVentas);
        $('#efe_real').text(moneda+" "+efectivoReal);
        $('.efe_p').text((efectivo).toFixed(2)+"%");
        $('.tar_p').text((tarjeta).toFixed(2)+"%");
        $('.t_mesas').text(item['data5'][0].total);
        $('#pro_m').text(moneda+" "+(totalVentasMesas).toFixed(2));
        $('.t_most').text(item['data8'][0].total);
        $('#pro_mo').text(moneda+" "+(totalVentasMostrador).toFixed(2));
        $('#pa_me').text(item['data11'][0].total);
        $('#pa_mo').text(item['data12'][0].total);
        //$('#meta_a').text((meta).toFixed(2)+"%");
        
        var con = 1;
        $.each(item['data9'][0], function(i, dato) {
            var importeTodos = parseFloat(dato.cantidad) * parseFloat(dato.precio);
            var porcentajeTodos = (parseFloat(importeTodos) * 100 ) / parseFloat(item['data1'][0].total_v);
            $('#lista_platos')
                .append(
                $('<tr/>')
                .append(
                    $('<td style="text-align: center;"/>')
                    .html(con++)
                )
                .append(
                    $('<td/>')
                    .html(dato.nombre_prod+' - '+dato.pres_prod)
                )
                .append(
                    $('<td style="text-align: center;"/>')
                    .html(dato.total)
                )
                .append(
                    $('<td style="text-align: center;"/>')
                    .html(moneda+" "+(importeTodos).toFixed(2))
                )
                .append(
                    $('<td class="text-navy" style="text-align: center;"/>')
                    .html((porcentajeTodos).toFixed(2)+'%')
                )
            )
        });

        var cont = 1;
        $.each(item['data10'][0], function(i, datu) {
            var importePlatos = parseFloat(datu.cantidad) * parseFloat(datu.precio);
            var porcentajePlatos = (parseFloat(importePlatos) * 100 ) / parseFloat(item['data1'][0].total_v);
            $('#lista_productos')
              .append(
                $('<tr/>')
                .append(
                    $('<td style="text-align: center;"/>')
                    .html(cont++)
                )
                .append(
                    $('<td/>')
                    .html(datu.nombre_prod+' - '+datu.pres_prod)
                )
                .append(
                    $('<td style="text-align: center;"/>')
                    .html(datu.total)
                )
                .append(
                    $('<td style="text-align: center;"/>')
                    .html(moneda+" "+(importePlatos).toFixed(2))
                )
                .append(
                    $('<td class="text-navy" style="text-align: center;"/>')
                    .html((porcentajePlatos).toFixed(2)+'%')
                )
            )
        });

    }
    
  });
}

/* Mostrar datos del grafico */
/*
function datosGrafico(){
  moment.locale('es');
    var siete = moment($("#dia_a")).format('[HOY]');
    var seis = moment($("#dia_a")).subtract(7, 'days').format('dddd - DD/MMM');
    var cinco = moment($("#dia_a")).subtract(14, 'days').format('dddd - DD/MMM');
    var cuatro = moment($("#dia_a")).subtract(21, 'days').format('dddd - DD/MMM');
    var tres = moment($("#dia_a")).subtract(28, 'days').format('dddd - DD/MMM');
    var dos = moment($("#dia_a")).subtract(35, 'days').format('dddd - DD/MMM');
    var uno = moment($("#dia_a")).subtract(42, 'days').format('dddd - DD/MMM');

    $.ajax({
    type: "POST",
    url: "?c=Tablero&a=DatosGraf",
    dataType: "json",
    success: function(item){

        var x7 = item.siete;
        var x6 = item.seis;
        var x5 = item.cinco;
        var x4 = item.cuatro;
        var x3 = item.tres;
        var x2 = item.dos;
        var x1 = item.uno;

        $("#margen_d").text('S/. '+item.margen);
        var marg = item.margen;
        var lineData = {
            labels: [uno, dos, tres, cuatro, cinco, seis, siete],
            datasets: [
                {
                    label: "Margen de venta",
                    backgroundColor: "rgba(220,220,220,0.5)",
                    borderColor: "rgba(220,220,220,1)",
                    pointBackgroundColor: "rgba(220,220,220,1)",
                    pointBorderColor: "#fff",
                    data: [marg, marg, marg, marg, marg, marg, marg]
                },
                {
                    label: "Total de ventas",
                    backgroundColor: "rgba(26,179,148,0.5)",
                    borderColor: "rgba(26,179,148,0.7)",
                    pointBackgroundColor: "rgba(26,179,148,1)",
                    pointBorderColor: "#fff",
                    data: [x1, x2, x3, x4, x5, x6, x7]
                }
            ]
        };

        var lineOptions = {
                responsive: true
            };

        var ctx = document.getElementById("lineChart").getContext("2d");
        new Chart(ctx, {type: 'line', data: lineData, options:lineOptions});
    }
});
}
*/

var setupSocketio = function(){

	
}