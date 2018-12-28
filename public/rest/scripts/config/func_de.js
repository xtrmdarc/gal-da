$(function() {
    mensaje();
    $('#frm-datos-empresa').formValidation({
        framework: 'bootstrap',
        fields: {
            razon_social: {
                validators: {
                    notEmpty: {
                        message: 'Dato obligatorio'
                    },
                    regexp: {
                        regexp: /^[a-záéíóúàèìòùäëïöüñ\s]+$/i,
                    message: 'Solo se permite letras'
                    }
                }
            },
            abrev_rs: {
                validators: {
                    notEmpty: {
                        message: 'Dato obligatorio'
                    },
                    regexp: {
                        regexp: /^[a-záéíóúàèìòùäëïöüñ\s]+$/i,
                    message: 'Solo se permite letras'
                    }
                }
            },
            igv: {
                validators: {
                    notEmpty: {
                        message: 'Dato obligatorio'
                    },
                    regexp: {
                        regexp: /^[0-9]+$/i,
                        message: 'Solo se permite números'
                    }
                }
            },
            ruc: {
                validators: {
                    notEmpty: {
                        message: 'Dato obligatorio'
                    },
                    regexp: {
                        regexp: /^[0-9]+$/i,
                        message: 'Solo se permite números'
                    },
                    stringLength: {
                        min: 11,
                        max: 11,
                        message: 'El máximo permitido son 11 caracteres'
                    }
                }
            },
            direccion: {
                validators: {
                    notEmpty: {
                        message: 'Dato obligatorio'
                    }
                }
            },
            telefono: {
                validators: {
                    regexp: {
                        regexp: /^[0-9]+$/i,
                        message: 'Solo se permite números'
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

var mensaje = function(){
    if ($("#m").val() == 'u'){
        toastr.info('Se ha modificado correctamente los datos!');
    }
}