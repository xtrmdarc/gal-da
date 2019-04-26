/**
 * Created by louis on 28/06/2018.
 */
$(function(){

    var btn_cambiar_password_s = $("#cambiar_password_s");
    var btn_cambiar_password_h = $("#cambiar_password_h");
    var btn_cambiar_tarjeta = $("#cambiar_tarjeta");
    var btn_cambiar_tarjeta_h = $("#cambiar_tarjeta_h");

    btn_cambiar_password_s.on("click",function() {
        $('#form-change-password').hide();
        $('#form-change-password-reset').fadeIn();
    });
    btn_cambiar_password_h.on("click",function() {
        $('#form-change-password-reset').hide();
        $('#form-change-password').fadeIn();
    });

    btn_cambiar_tarjeta.on("click",function() {
        $('#form-change-card').hide();
        $('#form-change-card-h').fadeIn();
    });
    btn_cambiar_tarjeta_h.on("click",function() {
        $('#form-change-card-h').hide();
        $('#form-change-card').fadeIn();
    });
});