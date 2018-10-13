/**
 * Created by louis on 20/07/2018.
 */
$(function(){
    listarTurnos();
    $('.clockpicker').clockpicker({
        donetext: 'Hecho',
        autoclose:true
    });

});

$(function() {
    $('#frm-turno')
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

            cod_turno = $('#cod_turno').val();
            nomb_turno = $('#nomb_turno').val();
            h_inicio_t = $('#h_inicio_t').val();
            h_fin_t = $('#h_fin_t').val();
            id_sucursal = $('#id_sucursal').val();

            $.ajax({
                dataType: 'JSON',
                type: 'POST',
                url: '/ajustesCrudTurnos',
                data: {
                    cod_turno: cod_turno,
                    nomb_turno: nomb_turno,
                    h_inicio_t: h_inicio_t,
                    h_fin_t: h_fin_t,
                    id_sucursal: id_sucursal,
                    _token : token
                },
                success: function (cod) {
                    if(cod == 0){
                        toastr.warning('Advertencia, Datos duplicados.');
                        return false;
                    } else if(cod == 1){
                        listarTurnos();
                        $('#mdl-turno').modal('hide');
                        toastr.success('Datos registrados, correctamente.');
                    } else if(cod == 2) {
                        listarTurnos();
                        $('#mdl-turno').modal('hide');
                        toastr.success('Datos modificados, correctamente.');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown){
                    console.log(errorThrown + ' ' + textStatus);
                }
            });
            return false;
        });
});

/* Mostrar datos en la tabla turnos */
var listarTurnos = function(){

    var token = $('meta[name="csrf-token"]').attr('content');
    var table = $('#table-turnos')
        .DataTable({
            "destroy": true,
            "responsive": true,
            "dom": "ftp",
            "bSort": false,
            "ajax":{
                "method": "POST",
                "url": "/ajustesListaTurnos",
                "dataSrc" : "",
                headers: {
                    'X-CSRF-TOKEN': token
                }
                /*
                 "beforeSend": function (request) {
                 ��������$('#loader').css('display','none');
                 ����  }
                 */
            },
            "columns":[
                {"data":"descripcion"},
                {"data":"h_inicio"},
                {"data":"h_fin"},
                {"data":"nombre_sucursal"},
                {"data":null,"render": function ( data, type, row) {
                    return '<button class="btn btn-success btn-xs" onclick="editarTurno('+data.id_turno+',\''+data.descripcion+'\',\''+data.h_inicio+'\',\''+data.h_fin+'\',\''+data.id_sucursal+'\');"> <i class="fa fa-edit"></i> Editar </button>'
                        +'&nbsp;<button class="btn btn-danger btn-xs" onclick="eliminarTurno('+data.id_turno+',\''+data.descripcion+'\',\''+data.nombre_sucursal+'\');"> <i class="fa fa-trash"></i></button></div>';
                }}
            ]
        });
}

/* Eliminar Turno */
var eliminarTurno = function(cod,nomb,sucur){
    $('#cod_turno_e').val(cod);
    $("#mensaje-turno").html("<center><h4>"+ nomb + ' - ' + sucur + "<br><br>�Desea eliminar?</h4></center>");
    $("#mdl-eliminar-turno").modal('show');
}

/* Editar Turno */
var editarTurno = function(cod,nomb,h_inicio,h_fin,sucur){
    $('#cod_turno').val(cod);
    $('#nomb_turno').val(nomb);
    $('#h_inicio_t').val(h_inicio);
    $('#h_fin_t').val(h_fin);
    $('#id_sucursal').selectpicker('val', sucur);
    $('#title-turno').text('Editar Turno');
    $('#mdl-turno').modal('show');
}

/* Boton Nuevo Turno */
$('.btn-turno').click( function() {
    $('#cod_turno').val('');
    $('#title-turno').text('Nuevo Turno');
    $('#mdl-turno').modal('show');
});

$('#mdl-turno').on('hidden.bs.modal', function() {
    $(this).find('form')[0].reset();
    $('#frm-turno').formValidation('resetForm', true);
    $('#id_sucursal').selectpicker('val', '');
});