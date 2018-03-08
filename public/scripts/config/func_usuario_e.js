$(function() {
    comboAreaProd();
    $('#frm-usuario').formValidation({
        framework: 'bootstrap',
        fields: {
            email: {
                validators: {
                    notEmpty: {
                        message: 'Dato obligatorio'
                    },
                    emailAddress:{
                        message: 'Ingrese un email v&aacute;lido'
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

/* Combo area de produccion */
var comboAreaProd = function(){
    if($("#id_rol").selectpicker('val') == 3){
        $('#area-p').css('display','block');
    }else{
        $('#area-p').css('display','none');
    }
}

/* Combinacion del combo rol - area produccion */
$('#id_rol').change( function() {
    if($("#id_rol").selectpicker('val') == 3){
        $('#area-p').css('display','block');
        $('#frm-usuario').formValidation('revalidateField', 'area-p');
    }else{
        $('#area-p').css('display','none');
        $("#cod_area").val('').selectpicker('refresh');
    }
});