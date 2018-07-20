$(function() {
    validarApertura();
    mensaje();
    $('#caja').addClass("active");
    $('#c-ing').addClass("active");
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
    $('#frm-nuevo-ing').formValidation({
        framework: 'bootstrap',
        excluded: ':disabled',
        fields: {
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

    $('#frm-anular-ing').formValidation({
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
    console.log('ingresa valida aperutra');
    $('#mdl-validar-apertura').modal('show');
  }
}

/* Anular ingreso administrativo */
function anularIngreso(cod){
    $('#cod_ing').val(cod);
    $("#mdl-anular-ing").modal('show');
}
 /* Modal de anular ingreso administrativo */
$('#mdl-anular-ing').on('hidden.bs.modal', function() {
    $(this).find('form')[0].reset();
    $('#frm-anular-ing').formValidation('resetForm', true);
});

/* Nuevo ingreso administrativo */
$('#mdl-nuevo-ing').on('hidden.bs.modal', function() {
    $('#frm-nuevo-ing').formValidation('resetForm', true);
    $("#importe").val('');
    $("#motivo").val('');
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