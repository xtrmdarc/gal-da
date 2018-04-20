$(function() {
    $('#frm-proveedor').formValidation({
        framework: 'bootstrap',
        fields: {
            razon_social: {
                validators: {
                    notEmpty: {
                        message: 'Dato obligatorio'
                    }
                }
            },
            direccion: {
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

$("#frm-consulta-ruc").submit(function(event) {
    event.preventDefault();
    $.getJSON("http://py-devs.com/api/ruc/" + $("#ruc_numero").val(), {
        format: "json"
    })
    .done(function(data) {
        $("#ruc").val(data.ruc);
        $("#razon_social").val(data.nombre);
        $("#direccion").val(data.domicilio_fiscal);
        $('#form').formValidation('revalidateField', 'razon_social');
        $('#form').formValidation('revalidateField', 'direccion');
    });
});
