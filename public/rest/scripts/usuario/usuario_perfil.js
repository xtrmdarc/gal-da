/**
 * Created by louis on 28/06/2018.
 */
$(function(){
    console.log("TEST");
    var btn_cambiar_password_s = $("#cambiar_password_s");
    var btn_cambiar_password_h = $("#cambiar_password_h");

    btn_cambiar_password_s.on("click",function() {
        $('#form-change-password').hide();
        $('#form-change-password-reset').fadeIn();
    });
    btn_cambiar_password_h.on("click",function() {
        $('#form-change-password-reset').hide();
        $('#form-change-password').fadeIn();
    });


});