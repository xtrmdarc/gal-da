/**
 * Created by louis on 11/04/2018.
 */

$(function() {
  console.log("Se CARGA PRIEMRO");
    $('.register-form-next').prop('disabled',false);
    this.activeStepIndex = 0;
  addListeners();

});

var addListeners = function() {
    $('.register-form-next').prop('disabled',false);
};

var b_register_step = $('.register-form-next');

b_register_step.on("click", function () {
    console.log("Entra al validation");

    $('.register-form-nav li, .register-form-step').removeClass('active');
    $('.register-form-navigation li').eq(this.activeStepIndex).addClass('active');
    $('.register-form-step').eq(this.activeStepIndex).addClass('active');
});