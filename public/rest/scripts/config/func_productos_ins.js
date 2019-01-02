/* Combo Unidad de medida */
var comboUnidadMedida = function(cod){
    var var1=0,var2=0;1==cod?(var1=1,var2=1):2==cod?(var1=2,var2=4):3==cod&&(var1=3,var2=4);
    $('#cod_med').selectpicker('destroy');
    $.ajax({
        type: "POST",
        url: "?c=Config&a=ComboUniMed",
        data: {
        	va1: var1,
        	va2: var2
        },
        success: function (response) {
            $('#cod_med').html(response);
            $('#cod_med').selectpicker();
        },
        error: function () {
            $('#cod_med').html('There was an error!');
        }
    });
}

$("#frm-receta").submit(function(){

    if($('#ins_cant').val() == ''){
        toastr.warning('Ingrese una cantidad al ingrediente.');
        return false;
    }else {

        var form = $(this);

        cod_pre=$('#cod_pre').val();
        ins_cod=$('#ins_cod').val();
        cod_med=$('#cod_med').val();
        ins_cant=$('#con_n').text();
      
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: '?c=Config&a=GuardarIng',
            data: {
                cod_pre: cod_pre,
                ins_cod: ins_cod,
                cod_med: cod_med,
                ins_cant: ins_cant
            },
              
            success: function (datos) {
                $('.list-ins').css('display','none');
                listarReceta();
                $('#ins_cant').val('');
                $('#con_n').text('0');
                toastr.success('Datos registrados, correctamente.');
            },
            error: function(jqXHR, textStatus, errorThrown){
                console.log(errorThrown + ' ' + textStatus);
            }   
        });
        return false;
    }
	
});

$(function() {
/* Busqueda del insumo */
$("#b_insumo").autocomplete({
    delay: 1,
    autoFocus: true,
    source: function (request, response) {
        $.ajax({
            url: '?c=Config&a=BuscarIns',
            type: "post",
            dataType: "json",
            data: {
                criterio: request.term
            },
            success: function (data) {
                response($.map(data, function (item) {
                    return {
                        id: item.id_ins,
                        cod_ins: item.cod_ins,
                        nombre: item.nomb_ins,
                        desc_m: item.desc_m,
                        id_med: item.id_med,
                        cod_g: item.cod_g
                    }
                }))
            }
        })
    },
    select: function (e, ui) {
		comboUnidadMedida(ui.item.cod_g);
		$('#cod_med option[value="'+ui.item.id_med+'"]').prop('selected', true);
		$('#insumo').text(ui.item.nombre);
        $('#ins_cod').val(ui.item.id);
        $('#desc_m').text(ui.item.desc_m);
        $('.list-ins').css('display','block');
        $('#b_insumo').val('');
        $('#b_insumo').focus();
        $('#ins_cant').val('');
    },
    change: function() {
        $("#b_insumo").val('');
        $("#b_insumo").focus();
    }
})
.autocomplete( "instance" )._renderItem = function( ul, item ) {
  return $('<li>')
    .append(item.cod_ins+' - '+item.nombre)
    .appendTo( ul );
};
$("#b_insumo").autocomplete("option", "appendTo", ".form_ins"); 
});

$('#ins_cant').keyup( function() {
	var opc=$("#cod_med").val();if(1==opc){var cal=($("#ins_cant").val()/1).toFixed(2);$("#con_n").text(cal)}else if(2==opc){var cal=($("#ins_cant").val()/1).toFixed(2);$("#con_n").text(cal)}else if(3==opc){var cal=($("#ins_cant").val()/1e3).toFixed(2);$("#con_n").text(cal)}else if(4==opc){var cal=($("#ins_cant").val()/1e6).toFixed(2);$("#con_n").text(cal)}else if(5==opc){var cal=($("#ins_cant").val()/1).toFixed(2);$("#con_n").text(cal)}else if(6==opc){var cal=($("#ins_cant").val()/1e3).toFixed(2);$("#con_n").text(cal)}else if(7==opc){var cal=($("#ins_cant").val()/2.20462).toFixed(2);$("#con_n").text(cal)}else if(8==opc){var cal=($("#ins_cant").val()/35.274).toFixed(2);$("#con_n").text(cal)}
});

$('#cod_med').on('change', function(){
    var opc=$("#cod_med").val();if(1==opc){var cal=($("#ins_cant").val()/1).toFixed(2);$("#con_n").text(cal)}else if(2==opc){var cal=($("#ins_cant").val()/1).toFixed(2);$("#con_n").text(cal)}else if(3==opc){var cal=($("#ins_cant").val()/1e3).toFixed(2);$("#con_n").text(cal)}else if(4==opc){var cal=($("#ins_cant").val()/1e6).toFixed(2);$("#con_n").text(cal)}else if(5==opc){var cal=($("#ins_cant").val()/1).toFixed(2);$("#con_n").text(cal)}else if(6==opc){var cal=($("#ins_cant").val()/1e3).toFixed(2);$("#con_n").text(cal)}else if(7==opc){var cal=($("#ins_cant").val()/2.20462).toFixed(2);$("#con_n").text(cal)}else if(8==opc){var cal=($("#ins_cant").val()/35.274).toFixed(2);$("#con_n").text(cal)}
});

