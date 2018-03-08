$(function() {
    moment.locale('es');
    listarDatos();
    mensaje();

    $('#frm-nueva-apertura').formValidation({
        framework: 'bootstrap',
        excluded: ':disabled',
        fields: {
            id_per: {
                validators: {
                    notEmpty: {
                        message: 'Dato obligatorio'
                    }
                }
            },
            id_caja: {
                validators: {
                    notEmpty: {
                        message: 'Dato obligatorio'
                    }
                }
            },
            id_turno: {
                validators: {
                    notEmpty: {
                        message: 'Dato obligatorio'
                    }
                }
            },
            monto: {
                validators: {
                    notEmpty: {
                        message: 'Dato obligatorio'
                    }
                }
            }
        }
    })

    $('#frm-cierre-caja').formValidation({
        framework: 'bootstrap',
        excluded: ':disabled',
        fields: {
            monto: {
                validators: {
                    notEmpty: {
                        message: 'Dato obligatorio'
                    }
                }
            },
            monto_sis: {
                validators: {
                    notEmpty: {
                        message: 'Dato obligatorio'
                    }
                }
            },
            fecha_cierre: {
                validators: {
                    notEmpty: {
                        message: 'Dato obligatorio'
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

    $('#caja').addClass("active");
    $('#c-apc').addClass("active");
    $('#fecha_cierre').datetimepicker({
        format: 'DD-MM-YYYY LT',
        locale: 'es-do'
    });
});

/* Mostrar datos en la tabla (Cajero, caja, turno, fecha apertura, etc) */
var listarDatos = function(){

    var moneda = $("#moneda").val();
    function filterGlobal () {
        $('#table').DataTable().search( 
            $('#global_filter').val()
        ).draw();
    }

    var table = $('#table')
    .DataTable({
        "destroy": true,
        "dom": "<'row'<'col-sm-6'><'col-sm-6'>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        "bSort": true,
        "ajax":{
            "method": "POST",
            "url": "?c=ACaja&a=Datos"
        },
        "columns":[
        {"data": "desc_per"},
        {"data": "desc_caja"},
        {"data": "desc_turno"},
        {"data":"fecha_a","render": function ( data, type, row ) {
            return '<i class="fa fa-calendar"></i> '+moment(data).format('DD-MM-Y');
        }},
        {"data":"fecha_a","render": function ( data, type, row ) {
            return '<i class="fa fa-clock-o"></i> '+moment(data).format('h:mm A');
        }},
            {"data":"monto_a","render": function ( data, type, row ) {
            return moneda+' '+data;
        }},
        {"data":null,"render": function ( data, type, row ) {
            if(data.estado == 'a'){
                return '<div class="text-center"><a class="btn btn-sm btn-info btn-xs" onclick="detalle('+data.id_apc+',\''+data.fecha_a+'\')"><i class="fa fa-eye"></i> Ver</a>'
                +'&nbsp;<a class="btn btn-sm btn-danger btn-xs" onclick="cierreCaja('+data.id_apc+',\''+data.desc_per+'\',\''+data.desc_caja+'\',\''+data.desc_turno+'\',\''+moment(data.fecha_a).format('DD-MM-Y hh:mm A')+'\')"><i class="fa fa-unlock"></i> Cerrar</a></div>';
            }
        }}
        ]
    });
    $('input.global_filter').on( 'keyup click', function () {
        filterGlobal();
    });
};

/* Cierre de caja */
var cierreCaja = function(cod_apc,desc_caje,desc_caja,desc_turno,fecha_a){
    $('#cod_apc').val(cod_apc);
    $('#fecha_aper').val(fecha_a);
    $("#monto_c").val('');
    $('#frm-cierre-caja').formValidation('revalidateField', 'monto');
    $("#mensaje").html('<center><h5>Cajero(a): '+ desc_caje +'<br>Caja: '+ desc_caja +' - Turno: '+ desc_turno +'</h5></center>');       
    $("#mdl-cierre-caja").modal('show');
    $.ajax({
        data: { cod_apc : $("#cod_apc").val(),
                fecha_ape : $("#fecha_aper").val(),
                fecha_cie : $("#fecha_cierre").val()},
        url:   '?c=ACaja&a=MontoSis',
        type:  'POST',
        dataType: 'json',
        success: function(data) {
            if (data.total_i != '') {
                var montoSist = (parseFloat(data.Datos.monto_a) + parseFloat(data.total_i) + parseFloat(data.Ingresos.total_i) - parseFloat(data.Gastos.total_g)).toFixed(2);
                $("#monto_sis").val(montoSist);
                $("#monto_sistema").val(montoSist);
            }
        }
    });
}

/* Modal cierre de caja */
$('#mdl-cierre-caja').on('hidden.bs.modal', function() {
    $("#monto_sis").val('0.00');
    $("#fecha_cierre").val($("#fechaC").val());
});

/* Detalle de Apertura, ingresos, egresos, etc */
var detalle = function(cod_apc,fecha_aper){
    var moneda = $("#moneda").val();
    moment.locale('es');
    $("#detalle").modal('show');
    $.ajax({
        data: { cod_apc : cod_apc,
                fecha_aper : fecha_aper},
        url:   '?c=ACaja&a=MontoSisDet',
        type:  'POST',
        dataType: 'json',
   
        success: function(data) {
            var fechaApertura = moment(data.Datos.fecha_a).format('Do MMMM YYYY, hh:mm A');
            var fechaCierre = moment(data.Datos.fecha_c).format('Do MMMM YYYY, hh:mm A');
            var totalIng = (parseFloat(data.total_i) + parseFloat(data.Ingresos.total_i)).toFixed(2);
            $("#apc").html(moneda+' '+data.Datos.monto_a);
            $("#t_ing").html(moneda+' '+totalIng);
            $("#t_egr").html(moneda+' '+data.Gastos.total_g);
            $("#d_cajero").html(data.Datos.desc_per);
            $("#d_caja").html(data.Datos.desc_caja);
            $("#d_turno").html(data.Datos.desc_turno);
            $("#d_fecha_a").html(fechaApertura);
            $("#d_fecha_c").html(fechaCierre);
            var montoEstimado = (parseFloat(data.Datos.monto_a) + parseFloat(data.total_i) + parseFloat(data.Ingresos.total_i) - parseFloat(data.Gastos.total_g)).toFixed(2);
            $("#t_est").html(moneda+' '+montoEstimado);
            $("#t_real").html(moneda+' '+data.Datos.monto_c);
            var montoDiferencia = (parseFloat(montoEstimado) - parseFloat(data.Datos.monto_c)).toFixed(2);
            $("#t_dif").html(moneda+' '+montoDiferencia);
        }
    }); 
}

/* Nueva Apertura de caja */
$('#mdl-nueva-apertura').on('hidden.bs.modal', function() {
    $(this).find('form')[0].reset();
    $('#frm-nueva-apertura').formValidation('resetForm', true);
    $("#id_usu").val('').selectpicker('refresh');
    $("#id_caja").val('').selectpicker('refresh');
    $("#id_turno").val('').selectpicker('refresh');
});

/* Accion desde la fecha */
$('#fecha_cierre').on('dp.change', function(e) { 
    $.ajax({
        data: { cod_apc : $("#cod_apc").val(),
                fecha_ape : $("#fecha_aper").val(),
                fecha_cie : $("#fecha_cierre").val()},
        url:   '?c=ACaja&a=MontoSis',
        type:  'POST',
        dataType: 'json',
        success: function(data) {
            if (data.total_i != '') {
                var montoSist = (parseFloat(data.Datos.monto_a) + parseFloat(data.total_i) + parseFloat(data.Ingresos.total_i) - parseFloat(data.Gastos.total_g)).toFixed(2);
                $("#monto_sis").val(montoSist);
                $("#monto_sistema").val(montoSist);
            }
        }
    }); 
});

$(".dec input").keypress(function(event) {
    var valueKey=String.fromCharCode(event.which);
    var keycode=event.which;
    if(valueKey.search('[0-9.]')!=0 && keycode!=8){
        return false;
    }
});

var mensaje = function(){
    if($("#m").val() == 'n'){
        toastr.success('Caja aperturada, correctamente.');
    }else if ($("#m").val() == 'd'){
        toastr.warning('Advertencia, Datos duplicados.');
    }else if ($("#m").val() == 'e'){
        toastr.warning('Advertencia, No se puede eliminar.');
    }else if ($("#m").val() == 'c'){
        toastr.success('Caja cerrada, correctamente.');
    }
}