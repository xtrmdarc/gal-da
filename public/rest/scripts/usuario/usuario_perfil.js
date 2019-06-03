/**
 * Created by louis on 28/06/2018.
 */
$(function(){

    listarRecibos();
    var btn_cambiar_password_s = $("#cambiar_password_s");
    var btn_cambiar_password_h = $("#cambiar_password_h");
    var btn_cambiar_tarjeta = $("#cambiar_tarjeta");
    var btn_cambiar_tarjeta_h = $("#cambiar_tarjeta_h");
    var btn_cancelar_plan = $("#cancelar_plan");

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
    btn_cancelar_plan.on("click",function() {
        $('#mdl-cancelar-plan').modal('show');
    });

    /*Change Password*/

    $('#form-change-password-reset')
        .formValidation({
            framework: 'bootstrap',
            excluded: ':disabled',
            fields: {
            }
        })
        .on('success.form.fv', function(e) {

            e.preventDefault();
            var $form = $(e.target),
                fv = $form.data('formValidation');
            var token = $('meta[name="csrf-token"]').attr('content');

            current_pass = $('#current-password').val();
            new_pass = $('#new-password').val();
            confirm_pass = $('#confirm-new-password').val();

            $.ajax({
                dataType: 'JSON',
                type: 'POST',
                url: '/password',
                data: {
                    current_pass: current_pass,
                    new_pass: new_pass,
                    confirm_pass: confirm_pass,
                    _token : token
                },
                success: function (data) {

                    if(data.cod == 0){
                        toastr.error('Tu contrase&ntilde;a actual es incorrecta.');
                        return false;
                    } else if(data.cod == 2) {
                        $('#form-change-password-reset').hide();
                        $('#form-change-password').fadeIn();
                        toastr.success('Datos modificados, correctamente.');
                        return false;
                    } else if(data.cod == 3) {
                        toastr.error('La contrase&ntilde;a de cofirmaci&oacute;n no coincide.');
                        return false;
                    }
                },
                error: function(jqXHR, textStatus, errorThrown){
                    console.log(errorThrown + ' ' + textStatus);
                }
            });
            return false;
        });
});

$('.credit-card').keyup(event,function(){
    re = new RegExp("[0-9]");
    // if(!($(event.target).val()).match(re))
    //     return;

    var tarjeta = GetCardType($(event.target).val() );

    if(tarjeta.nombre)
        $(event.target).css('background','#fff url(/home/images/icons/'+tarjeta.logo+') no-repeat right ');
    else $(event.target).css('background','none');

    $(event.target).css('background-size','48px');
    $(event.target).css('background-position','99%');
});

function GetCardType(number)
{
    let tarjeta = {};

    // visa
    var re = new RegExp("^4");
    if (number.match(re) != null)
    {
        tarjeta.nombre = "Visa";
        tarjeta.logo = "visa_logo.png";
        return tarjeta;
    }

    // Mastercard
    // Updated for Mastercard 2017 BINs expansion
    if (/^(5[1-5][0-9]{14}|2(22[1-9][0-9]{12}|2[3-9][0-9]{13}|[3-6][0-9]{14}|7[0-1][0-9]{13}|720[0-9]{12}))$/.test(number))
    {
        tarjeta.nombre = "Mastercard";
        tarjeta.logo = "mastercard_logo.png";
        return tarjeta;
    }



    // AMEX
    re = new RegExp("^3[47]");
    if (number.match(re) != null)
    {
        tarjeta.nombre = "American Express";
        tarjeta.logo = "amex_logo.png";
        return tarjeta;
    }


    // Discover
    // re = new RegExp("^(6011|622(12[6-9]|1[3-9][0-9]|[2-8][0-9]{2}|9[0-1][0-9]|92[0-5]|64[4-9])|65)");
    // if (number.match(re) != null)
    //     return "Discover";

    // Diners
    re = new RegExp("^36");
    if (number.match(re) != null)
    {
        tarjeta.nombre = "Diners";
        tarjeta.logo = "diners_logo.png";
        return tarjeta;
    }


    // Diners - Carte Blanche
    re = new RegExp("^30[0-5]");
    if (number.match(re) != null)
    {
        tarjeta.nombre = "Diners - Carte Blanche";
        tarjeta.logo = "diners_logo.png";
        return tarjeta;
    }

    // JCB
    // re = new RegExp("^35(2[89]|[3-8][0-9])");
    // if (number.match(re) != null)
    //     return "JCB";

    // Visa Electron
    re = new RegExp("^(4026|417500|4508|4844|491(3|7))");
    if (number.match(re) != null)
    {
        tarjeta.nombre = "Visa electron";
        tarjeta.logo = "visa_logo.png";
        return tarjeta;
    }
    tarjeta.nombre = "";
    tarjeta.logo = "";

    return tarjeta;
}

/* Mostrar datos en la tabla de recibos */
var listarRecibos = function(){

    var token = $('meta[name="csrf-token"]').attr('content');
    var table = $('#table-recibos')
        .DataTable({
            "destroy": true,
            "responsive": true,
            "dom": "ftp",
            "bSort": false,
            "ajax":{
                "method": "POST",
                "url": "/ajustesListaRecibos",
                "dataSrc" : "",
                headers: {
                    'X-CSRF-TOKEN': token
                }
            },
            "columns":[
                {"data":"fecha_venta"},
                {"data":"precio"},
                {"data":null,"render": function (data, type, row) {
                    //console.log(data.id_g);
                    if(data.id_g){
                        return '<div><a class="btn btn-success btn-xs" href="/recibo_descargar_pdf/'+data.id_g+'" target="_blank"><i class="fa fa-download"></i> Descargar Recibo</a>';
                    }
                }}
            ]
        });
}