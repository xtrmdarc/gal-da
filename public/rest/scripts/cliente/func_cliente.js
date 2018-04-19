$(function() {
    mensaje();
    function filterGlobal () {
    $('#table').DataTable().search( 
        $('#global_filter').val()
    ).draw();
    }
    $('#table').DataTable({
        "dom": "<'row'<'col-sm-6'><'col-sm-6'>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    });
    $('input.global_filter').on( 'keyup click', function () {
        filterGlobal();
    });
    $('#frm-estado-cliente').formValidation({
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

/* Estado del cliente Activo - Inactivo */
var estadoCliente = function(cod_cliente){
    $('#cod_cliente').val(cod_cliente);
    $("#mdl-estado-cliente").modal('show');
}

 /* Modal estado del cliente */
$('#mdl-estado-cliente').on('hidden.bs.modal', function() {
    $(this).find('form')[0].reset();
    $('#frm-estado-cliente').formValidation('resetForm', true);
    $("#estado_cliente").val('').selectpicker('refresh');
});

/* Eliminar Cliente */
var eliminarCliente = function(cod_cliente,desc_c){
    $('#cod_cliente_e').val(cod_cliente);  
    $("#mensaje-c").html("<center><h4>" + desc_c + "<br><br>¿Desea eliminar?</h4></center>");         
    $("#mdl-eliminar-cliente").modal('show');
}

var mensaje = function(){
    if($("#m").val() == 'n'){
        toastr.success('Datos registrados, correctamente.');
    }else if ($("#m").val() == 'u'){
        toastr.success('Datos modificados, correctamente.');
    }else if ($("#m").val() == 'd'){
        toastr.warning('Estas intentando ingresar datos que ya existen!');
    }else if ($("#m").val() == 'e'){
        toastr.warning('Advertencia, El cliente no puede ser eliminado.');
    }
}