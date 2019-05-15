/**
 * Created by louis on 15/05/2019.
 */
$(function(){

    var btn_cambiar_certificado = $("#edit_certi");
    var btn_cancelar_certificado = $("#cancel_certi");

    btn_cambiar_certificado.on("click",function() {
        $('#save_certificado').hide();
        $('#edit_certificado').fadeIn();
    });
    btn_cancelar_certificado.on("click",function() {
        $('#edit_certificado').hide();
        $('#save_certificado').fadeIn();
    });
});
