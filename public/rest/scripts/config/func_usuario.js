$(function() {
    $('#table').DataTable();
    mensaje();
    $('#frm-estado-usu').formValidation({
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

/* Estado usuario */
var estadoUsuario = function(cod_usu,cod_estado){
    $('#cod_usu').val(cod_usu);     
    $("#mdl-estado-usu").modal('show');
    $("#estado_usu").val(cod_estado);
    $("#estado_usu").selectpicker("refresh");
}

$('#mdl-estado-usu').on('hidden.bs.modal', function() {
    $(this).find('form')[0].reset();
    $('#frm-estado-usu').formValidation('resetForm', true);
    $("#estado_usu").val('').selectpicker('refresh');
});

/* Eliminar usuario */
var eliminarUsuario = function(cod_usu,desc_u){
    $('#cod_usu_e').val(cod_usu);   
    $("#mensaje-u").html("<center><h4>" + desc_u + "<br><br>¿Desea eliminar?</h4></center>");         
    $("#mdl-eliminar-usu").modal('show');
}

var mensaje = function(){
    if($("#m").val() == 'n'){
        toastr.success('Se ha registrado correctamente un nuevo usuario!');
        //return true;
    }else if ($("#m").val() == 'u'){
        toastr.info('Se ha modificado correctamente los datos del usuario!');
    }else if ($("#m").val() == 'd'){
        toastr.warning('Estas intentando ingresar datos que ya existen!');
    }else if ($("#m").val() == 'e'){
        toastr.error('No puedes eliminar los datos del usuario');
    }
}

$('#frm-eliminar-usu').on('submit',function(e){
    console.log('entro aqui');
    e.preventDefault();
    var $form = $(e.target);

    $.ajax({
        data: $form.serialize(),
        url:   $form.attr('action'),
        type:  'POST',
        dataType: 'json',
        dataSrc:"",
        headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        success: function(data) {
            console.log(data);
            if (data == 0) {
                alert('Usuario activo')
            }
            else if(data==1){
                window.location.replace('/ajustesUsuarios');
            }
        }
    });


});