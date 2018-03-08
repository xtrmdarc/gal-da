$(document).ready(function () {
	window.setTimeout(function() {
		$(".alert").fadeTo(3000, 0).slideUp(3000, function(){
			$(this).remove(); 
		});
	}, 3000);
	document.oncontextmenu=function(){return!1},document.onselectstart=function(){return"text"!=event.srcElement.type&&"textarea"!=event.srcElement.type&&"password"!=event.srcElement.type?!1:!0},window.sidebar&&(document.onmousedown=function(e){var t=e.target;return"SELECT"==t.tagName.toUpperCase()||"INPUT"==t.tagName.toUpperCase()||"TEXTAREA"==t.tagName.toUpperCase()||"PASSWORD"==t.tagName.toUpperCase()?!0:!1}),document.ondragstart=function(){return!1};
	$('.opc1').css('display','none');
	$('.opc2').css('display','none');
	$('.opc3').css('display','none');

	$('#frm-login').formValidation({
        framework: 'bootstrap',
        fields: {
            txt_caja: {
                validators: {
                    notEmpty: {
                        message: 'Dato obligatorio'
                    }
                }
            },
            txt_turno: {
                validators: {
                    notEmpty: {
                        message: 'Dato obligatorio'
                    }
                }
            }
        }
    })
});

$('.cb_tpuser').change( function() {
    if($('#cb_tpuser').val() == 1 || $('#cb_tpuser').val() == 2){
    	$('.opc1').css('display','block');
		$('.opc2').css('display','block');
		$('.opc3').css('display','block');
    } else if($('#cb_tpuser').val() == 3 || $('#cb_tpuser').val() == 4){
    	$('.opc1').css('display','none');
		$('.opc2').css('display','block');
		$('.opc3').css('display','block');
		$('.btn-primary').removeClass('disabled');
		$('.btn-primary').removeAttr("disabled")
    }
});