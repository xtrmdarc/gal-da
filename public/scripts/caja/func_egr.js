$(function() {
    validarApertura();
    mensaje();
    $('#caja').addClass("active");
    $('#c-egr').addClass("active");
    function filterGlobal () {
    $('#table').DataTable().search(
    $('#global_filter').val()
        ).draw();
    }
    $('#table').DataTable({
        "order": [[ 1, "desc" ]],
        "dom": "<'row'<'col-sm-6'><'col-sm-6'>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    });
    $('input.global_filter').on( 'keyup click', function () {
        filterGlobal();
    });
    $('input[type="radio"].flat-red').iCheck({
      radioClass: 'iradio_square-blue'
    });
    $('.DatePicker')
        .datepicker({
            format: 'dd-mm-yyyy'
        })
    .on('changeDate', function(e) {
            $('#frm-nuevo-gasto').formValidation('revalidateField', 'fecha_comp');
        });
    $('#frm-nuevo-gasto').formValidation({
        framework: 'bootstrap',
        excluded: ':disabled',
        fields: {
            id_tipo_doc: {
                validators: {
                    notEmpty: {
                        message: 'Dato obligatorio'
                    }
                }
            },
            importe: {
                validators: {
                    notEmpty: {
                        message: 'Dato obligatorio'
                    },
                    regexp: {
                        regexp: /^[0-9.]+$/i,
                        message: 'Solo se permite números'
                    }
                }
            },
            motivo: {
                validators: {
                    notEmpty: {
                        message: 'Dato obligatorio'
                    },
                    regexp: {
                        regexp: /^[0-9-a-záéíóúàèìòùäëïöüñ./\s]+$/i,
                        message: 'Solo se permite algunos caracteres'
                    }
                }
            }
        }
    })

    $('#frm-anular-gasto').formValidation({
        framework: 'bootstrap',
        excluded: ':disabled',
        fields: {
            estado: {
                validators: {
                    notEmpty: {
                        message: 'Dato obligatorio'
                    }
                }
            }
        }
    })

    .on('success.form.fv', function(e) {
            // Prevent form submission
            e.preventDefault();
            var $form = $(e.target);
            var fv = $form.data('formValidation');
            fv.defaultSubmit();
    });
});

/* Validar si se aperturo caja */
var validarApertura = function(){
  if($('#cod_ape').val() == 0){
    $('#mdl-validar-apertura').modal('show');
  }
}

/* Anular gasto administrativo */
function anularGasto(cod){
    $('#cod_ga').val(cod);
    $("#mdl-anular-gasto").modal('show');
}
 /* Modal de anular gasto administrativo */
$('#mdl-anular-gasto').on('hidden.bs.modal', function() {
    $(this).find('form')[0].reset();
    $('#frm-anular-gasto').formValidation('resetForm', true);
});

/* Nuevo gasto administrativo */
$('#mdl-nuevo-gasto').on('hidden.bs.modal', function() {
    $("#rating_0").iCheck('check');
    $('#frm-nuevo-gasto').formValidation('resetForm', true);
    $("#id_tipo_doc").val('').selectpicker('refresh');
    $("#id_per").val('').selectpicker('refresh');
    $("#importe").val('');
    $("#serie_doc").val('');
    $("#num_doc").val('');
    $("#fecha_comp").val('');
    $("#motivo").val('');
});

/* Opciones de Gastos Administrativos. Servicios-Compras-Remuneraciones */
$('input:radio[id=rating_0]').on('ifChecked', function(event){
  $("#opc").css("display","block");
  $("#opc-per").css("display","none");
  $("#id_per").val('').selectpicker('refresh');
  $("#id_tipo_doc").val('').selectpicker('refresh');
});
$('input:radio[id=rating_1]').on('ifChecked', function(event){
  $("#opc").css("display","block");
  $("#opc-per").css("display","none");
  $("#id_per").val('').selectpicker('refresh');
  $("#id_tipo_doc").val('').selectpicker('refresh');
});
$('input:radio[id=rating_2]').on('ifChecked', function(event){
  $("#id_tipo_doc").val('').selectpicker('refresh');
  $("#serie_doc").val('');
  $("#num_doc").val('');
  $("#fecha_comp").val('');
  $("#opc").css("display","none");
  $("#opc-per").css("display","block");
  $('#id_per').prop('required',true);
  $('#frm-nuevo-gasto').formValidation('revalidateField', 'id_per');
});

$(".let input").keypress(function(event) {
    var valueKey=String.fromCharCode(event.which);
    var keycode=event.which;
    if(valueKey.search('[A-ZÁÉÍÓÚ ]')!=0 && keycode!=8 && keycode!=20){
        return false;
    }
});

$(".let textarea").keypress(function(event) {
    var valueKey=String.fromCharCode(event.which);
    var keycode=event.which;
    if(valueKey.search('[A-ZÁÉÍÓÚ ]')!=0 && keycode!=8 && keycode!=20){
        return false;
    }
});

$(".letnum input").keypress(function(event) {
    var valueKey=String.fromCharCode(event.which);
    var keycode=event.which;
    if(valueKey.search('[0-9A-ZÁÉÍÓÚ ]')!=0 && keycode!=8 && keycode!=20){
        return false;
    }
});

$(".dec input").keypress(function(event) {
    var valueKey=String.fromCharCode(event.which);
    var keycode=event.which;
    if(valueKey.search('[0-9.]')!=0 && keycode!=8){
        return false;
    }
});

$(".ent input").keypress(function(event) {
    var valueKey=String.fromCharCode(event.which);
    var keycode=event.which;
    if(valueKey.search('[0-9]')!=0 && keycode!=8){
        return false;
    }
});

var mensaje = function(){
    if($("#m").val() == 'n'){
        toastr.success('Datos registrados, correctamente.');
    }else if ($("#m").val() == 'd'){
        toastr.warning('Advertencia, Datos duplicados.');
    }else if ($("#m").val() == 'e'){
        toastr.error('No puedes eliminar el elemento seleccionado');
    }else if ($("#m").val() == 'a'){
        toastr.success('Datos anulados, correctamente');
    }
}