$(function() {
  mensaje();
  $('#frm-rol').formValidation({
        framework: 'bootstrap',
        excluded: ':disabled',
        fields: {
            descripcion: {
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

$('#mdl-rol').on('hidden.bs.modal', function() {
    $(this).find('form')[0].reset();
    $('#frm-rol').formValidation('resetForm', true);
});

/* Editar rol */
var editarRol = function(cod_rol,desc_rol){
    $('#cod_rol').val(cod_rol);
    $('#descripcion_r').val(desc_rol);    
    $("#mdl-rol").modal('show');
}

/* Eliminar rol */
var eliminarRol = function(cod_rol,desc_rol){
    $('#cod_rol_e').val(cod_rol);
    $("#mensaje-r").html("<center><h4>Rol: " + desc_rol + "<br><br>¿Desea eliminar?</h4></center>");         
    $("#mdl-eliminar-rol").modal('show');
}

$(".let input").keypress(function(event) {
    var valueKey=String.fromCharCode(event.which);
    var keycode=event.which;
    if(valueKey.search('[A-ZÁÉÍÓÚÑ ]')!=0 && keycode!=8 && keycode!=20){
        return false;
    }
});

$(".letnum input").keypress(function(event) {
    var valueKey=String.fromCharCode(event.which);
    var keycode=event.which;
    if(valueKey.search('[0-9A-ZÁÉÍÓÚÑ ]')!=0 && keycode!=8 && keycode!=20){
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
        toastr.success('Se ha registrado un nuevo rol!');
    }else if ($("#m").val() == 'u'){
        toastr.info('Se ha modificado correctamente los datos!');
    }else if ($("#m").val() == 'd'){
        toastr.warning('Estas intentando ingresar datos que ya existen!');
    }else if ($("#m").val() == 'e'){
        toastr.error('No puedes eliminar este rol');
    }
}

