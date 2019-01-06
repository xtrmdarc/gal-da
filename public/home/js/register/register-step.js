/**
 * Created by louis on 11/04/2018.
 */

$(function() {
    //console.log("Se CARGA PRIEMRO");
});

/*function checkForm()
{
    var elements = document.forms[0].elements;
    console.log('TEST' + elements.length);
    var cansubmit= true;
    for(var i = 0; i < elements.length; i++)
    {
        if(elements[i].value.length == 0 && elements[i].type != "button")
        {
            cansubmit = false;
        }

    }

    document.getElementById("btn-register-account").disabled = !cansubmit;
};
*/

var b_register_step = $('#btn-register-account');

var b_register_step_payment_free = $('#btn-register-payment-free');
var b_register_step_payment_all = $('#btn-register-payment-all');

var header_nav_account = $('.site-color-account');
var header_nav_plan = $('.site-color-plan');

header_nav_account.on("click", function () {
    $('.register-form-nav li.site-color-account, .register-form-step').addClass('active');
    $('.register-form-nav li.site-color-plan, .register-form-step-plan').removeClass('active');
    $('.register-form-nav li.site-color-payment, .register-form-step-payment').removeClass('active');
});
header_nav_plan.on("click", function () {
    $('.register-form-nav li.site-color-account, .register-form-step').removeClass('active');
    $('.register-form-nav li.site-color-payment, .register-form-step-payment').removeClass('active');
    $('.register-form-nav li.site-color-plan, .register-form-step-plan').addClass('active');
});

b_register_step.on("click", function () {
    //document.getElementById("register-form-galda").submit();
    $('.register-form-nav li.site-color-account, .register-form-step').removeClass('active');
    $('.register-form-nav li.site-color-plan, .register-form-step-plan').addClass('active');
    $( "#btn-nav-plan" ).prop( "disabled", false );
});

b_register_step_payment_free.on("click", function () {
    //document.getElementById("register-form-galda").submit();
    $('.register-form-nav li.site-color-plan, .register-form-step-plan').removeClass('active');
    $('.register-form-nav li.site-color-payment, .register-form-step-payment').addClass('active');
});

b_register_step_payment_all.on("click", function () {
    document.getElementById("register-form-galda").submit();
});