$(function() {
    mensaje();
    $('#compras').addClass("active");
    $('#c-proveedores').addClass("active");
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
    } );
    $('#frm-estado-proveedor').formValidation({
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

/* Estado del proveedor Activo - Inactivo */
var estadoProveedor = function(cod){
    $('#cod_prov').val(cod); 
    $("#mdl-estado-proveedor").modal('show');
}

/* Modal estado del proveedor */
$('#mdl-estado-proveedor').on('hidden.bs.modal', function() {
    $(this).find('form')[0].reset();
    $('#frm-estado-proveedor').formValidation('resetForm', true);
    $("#estado_proveedor").val('').selectpicker('refresh');
});

var mensaje = function(){
    if($("#m").val() == 'n'){
        toastr.success('Datos registrados, correctamente.');
    }else if ($("#m").val() == 'u'){
        toastr.success('Datos modificados, correctamente.');
    }else if ($("#m").val() == 'd'){
        toastr.warning('Estas intentando ingresar datos que ya existen!');
    }else if ($("#m").val() == 'e'){
        toastr.warning('Advertencia, El proveedor no puede ser eliminado.');
    }
}