$(function() {
    //comboAreaProd();
    HandleRolSelection();
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
        $('input[name="pin"]').prop('disabled', false);
        
    }
    else{
        $('#pin_div').css('display','none');
        $('input[name="pin"]').prop('disabled', true);
        
    }

    if($("#id_rol").selectpicker('val') == 3){
        $('#area-p').css('display','block');
        $('input[name="cod_area"]').prop('disabled', false);
    }else{
        $('#area-p').css('display','none');
        $('input[name="cod_area"]').prop('disabled', true);
    }
    
    if( $("#id_rol").selectpicker('val') == 5){
        $('#dni_div').css('display','none');
        
        $('#nombres_div').css('display','none');
        
        $('#app_div').css('display','none');

        $('#apm_div').css('display','none');

        $('#email_div').css('display','none');

        $('input[name="dni"]').prop('disabled', true);
        
        $('input[name="nombres"]').prop('disabled', true);
        
        $('input[name="ape_paterno"]').prop('disabled', true);

        $('input[name="ape_materno"]').prop('disabled', true);

        $('input[name="email"]').prop('disabled', true);
    }
    else{
        $('#dni_div').css('display','block');
       
        $('#nombres_div').css('display','block');

        $('#app_div').css('display','block');

        $('#apm_div').css('display','block');

        $('#email_div').css('display','block');

        $('input[name="dni"]').prop('disabled', false);
        
        $('input[name="nombres"]').prop('disabled', false);
        
        $('input[name="ape_paterno"]').prop('disabled', false);

        $('input[name="ape_materno"]').prop('disabled', false);

        $('input[name="email"]').prop('disabled', false);
    }

}

/* Combinacion del combo rol - area produccion */
$('#id_rol').change( function(event) {
    HandleRolSelection();
    
});

$('#id_sucursal').on('change',function(){
    
    $.ajax({
        dataType: 'JSON',
        type: 'POST',
        url: '/areasProdXSucursal',
        data: {
            id_sucursal: $('#id_sucursal').val()
        },
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        success: function (areas_prod) { 
            $('#cod_area').empty();
            var arrAreas;
            $.each(areas_prod,function(i,v){
                arrAreas =  arrAreas + `<option value="${v.id_areap}">${v.nombre}</option>`;
            });
            $('#cod_area').append(arrAreas);
            $('#cod_area').selectpicker('refresh');
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.log(errorThrown + ' ' + textStatus);
        }   
    });

});

function HandleRolSelection(){
    if($("#id_rol").selectpicker('val') == 4){
        
        $('#pin_div').css('display','block');
        $('#frm-usuario').formValidation('revalidateField', 'area-p');
        $('input[name="pin"]').prop('disabled', false);
    }
    else{
        $('#pin_div').css('display','none');
        $('input[name="pin"]').prop('disabled', true);
        
    }

    if($("#id_rol").selectpicker('val') == 3){
        
        $('#area-p').css('display','block');
        $('#frm-usuario').formValidation('revalidateField', 'area-p');
        $('input[name="cod_area"]').prop('disabled', false);

    }
    else{
        
        $('#area-p').css('display','none');
        $("#cod_area").val('').selectpicker('refresh');
        $('input[name="cod_area"]').prop('disabled', true);
    }

    if( $("#id_rol").selectpicker('val') == 5){
        $('#dni_div').css('display','none');
        
        $('#nombres_div').css('display','none');
        
        $('#app_div').css('display','none');

        $('#apm_div').css('display','none');

        $('#email_div').css('display','none');

        $('#pin_div').css('display','none');

        $('input[name="dni"]').prop('disabled', true);
        
        $('input[name="nombres"]').prop('disabled', true);
        
        $('input[name="ape_paterno"]').prop('disabled', true);

        $('input[name="ape_materno"]').prop('disabled', true);

        $('input[name="email"]').prop('disabled', true);
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
        
        $('input[name="dni"]').prop('disabled', false);
        
        $('input[name="nombres"]').prop('disabled', false);
        
        $('input[name="ape_paterno"]').prop('disabled', false);

        $('input[name="ape_materno"]').prop('disabled', false);

        $('input[name="email"]').prop('disabled', false);
      
       
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