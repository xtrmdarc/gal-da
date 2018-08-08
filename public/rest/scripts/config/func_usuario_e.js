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
    
    if($("#id_rol").selectpicker('val') == 4){
        
        $('#pin_div').css('display','block');
        
    }
    else{
        $('#pin_div').css('display','none');
        
    }

    if($("#id_rol").selectpicker('val') == 3){
        $('#area-p').css('display','block');
    }else{
        $('#area-p').css('display','none');
    }
    
    if( $("#id_rol").selectpicker('val') == 5){
        $('#dni_div').css('display','none');
        
        $('#nombres_div').css('display','none');
        
        $('#app_div').css('display','none');

        $('#apm_div').css('display','none');

        $('#email_div').css('display','none');
    }
    else{
        $('#dni_div').css('display','block');
       
        $('#nombres_div').css('display','block');

        $('#app_div').css('display','block');

        $('#apm_div').css('display','block');

        $('#email_div').css('display','block');
    }
}

/* Combinacion del combo rol - area produccion */
$('#id_rol').change( function(event) {
    HandleRolSelection();
    
});


function HandleRolSelection(){
    if($("#id_rol").selectpicker('val') == 4){
        
        $('#pin_div').css('display','block');
        $('#frm-usuario').formValidation('revalidateField', 'area-p');
    }
    else{
        $('#pin_div').css('display','none');
        
    }

    if($("#id_rol").selectpicker('val') == 3){
        
        $('#area-p').css('display','block');
        $('#frm-usuario').formValidation('revalidateField', 'area-p');

    }
    else{
        
        $('#area-p').css('display','none');
        $("#cod_area").val('').selectpicker('refresh');
    }

    if( $("#id_rol").selectpicker('val') == 5){
        $('#dni_div').css('display','none');
        
        $('#nombres_div').css('display','none');
        
        $('#app_div').css('display','none');

        $('#apm_div').css('display','none');

        $('#email_div').css('display','none');

        $('#pin_div').css('display','none');
    }
    else{
        
        
        $('#dni_div').css('display','block');
        $('#frm-usuario').formValidation('revalidateField', 'area-p');
        
        $('#nombres_div').css('display','block');
        $('#frm-usuario').formValidation('revalidateField', 'area-p');
        
        $('#app_div').css('display','block');
        $('#frm-usuario').formValidation('revalidateField', 'area-p');

        $('#apm_div').css('display','block');
        $('#frm-usuario').formValidation('revalidateField', 'area-p');

        $('#email_div').css('display','block');
        $('#frm-usuario').formValidation('revalidateField', 'area-p');
      
       
    }
}

$(".toggle-password").click(function() {

    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
    
});