$(function(){
    listarCajas();
});

$(function() {
    $('#frm-caja')
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

            cod_caja = $('#cod_caja').val();
            nomb_caja = $('#nomb_caja').val();
            estado_caja = $('#estado_caja').val();
            id_sucursal = $('#id_sucursal').val();

            $.ajax({
                dataType: 'JSON',
                type: 'POST',
                url: '/ajustesCrudCaja',
                data: {
                    cod_caja: cod_caja,
                    nomb_caja: nomb_caja,
                    estado_caja: estado_caja,
                    id_sucursal: id_sucursal,
                    _token : token
                },
                success: function (cod) {
                    //console.log(cod);
                    if(cod == 0){
                        toastr.warning('Advertencia, Datos duplicados.');
                        return false;
                    } else if(cod == 1){
                        listarCajas();
                        $('#mdl-caja').modal('hide');
                        toastr.success('Datos registrados, correctamente.');
                    } else if(cod == 2) {
                        listarCajas();
                        $('#mdl-caja').modal('hide');
                        toastr.success('Datos modificados, correctamente.');
                    }
                    else if (cod==4){
                        toastr.warning('No puede descativar una caja en uso.');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown){
                    console.log(errorThrown + ' ' + textStatus);
                }
            });
            return false;
        });
});

/* Mostrar datos en la tabla caja */
var listarCajas = function(){

    var token = $('meta[name="csrf-token"]').attr('content');
    var table = $('#table-caja')
        .DataTable({
            "destroy": true,
            "responsive": true,
            "dom": "ftp",
            "bSort": false,
            "ajax":{
                "method": "POST",
                "url": "/ajustesListaCaja",
                "dataSrc" : "",
                headers: {
                    'X-CSRF-TOKEN': token
                }
                /*
                 "beforeSend": function (request) {
                         $('#loader').css('display','none');
                       }
                 */
            },
            "columns":[
                {"data":"descripcion"},
                {"data":"nombre_sucursal"},
                {"data":null,"render": function ( data, type, row) {
                    if(data.estado == 'a'){
                        return '<span class="label label-primary">ACTIVA</span>';
                    } else if (data.estado == 'i'){
                        return '<span class="label label-danger">INACTIVA</span>'
                    }
                }},
                {"data":null,"render": function ( data, type, row) {
                    if(data.plan_id == 1){
                        if(data.id_rol_v == '1' && data.plan_estado == 'f'){
                            return '<div class="text-right"><button class="btn btn-success btn-xs" onclick="editarCaja('+data.id_caja+',\''+data.descripcion+'\',\''+data.id_sucursal+'\',\''+data.estado+'\',\''+data.nombre_sucursal+'\');"><i class="fa fa-edit"></i>Editar</button>';
                            /*+'&nbsp;<button class="btn btn-danger btn-xs" onclick="eliminarCaja('+data.id_caja+',\''+data.descripcion+'\',\''+data.nombre_sucursal+'\');"> <i class="fa fa-trash"></i></button></div>';*/
                        }else{
                            return '<div class="text-right"></div>';
                        }
                        if(data.id_rol_v == '2'  && data.plan_estado == 'f') {
                            return '<div class="text-right"><button class="btn btn-success btn-xs" onclick="editarCaja('+data.id_caja+',\''+data.descripcion+'\',\''+data.id_sucursal+'\',\''+data.estado+'\',\''+data.nombre_sucursal+'\');"><i class="fa fa-edit"></i>Editar</button>';
                        }else{
                            return '<div class="text-right"></div>';
                        }
                    }
                    if(data.plan_id == 2){
                        if(data.id_rol_v == '1'){
                            return '<div class="text-right"><button class="btn btn-success btn-xs" onclick="editarCaja('+data.id_caja+',\''+data.descripcion+'\',\''+data.id_sucursal+'\',\''+data.estado+'\',\''+data.nombre_sucursal+'\');"><i class="fa fa-edit"></i>Editar</button>';
                            /*+'&nbsp;<button class="btn btn-danger btn-xs" onclick="eliminarCaja('+data.id_caja+',\''+data.descripcion+'\',\''+data.nombre_sucursal+'\');"> <i class="fa fa-trash"></i></button></div>';*/
                        }
                        if(data.id_rol_v == '2') {
                            return '<div class="text-right"><button class="btn btn-success btn-xs" onclick="editarCaja('+data.id_caja+',\''+data.descripcion+'\',\''+data.id_sucursal+'\',\''+data.estado+'\',\''+data.nombre_sucursal+'\');"><i class="fa fa-edit"></i>Editar</button>';
                        }
                    }
                }}
            ]
        });
}

/* Eliminar Caja */
var eliminarCaja = function(cod,nomb,sucur){
    $('#cod_caja_e').val(cod);
    $("#mensaje-caja").html("<center><h4>"+ nomb + ' - ' + sucur + "<br><br>¿Desea eliminar?</h4></center>");
    $("#mdl-eliminar-caja").modal('show');
}

/* Editar caja */
var editarCaja = function(cod,nomb,sucur,est,nombre_sucursal){

    if(cod)
    {
        $('#cod_caja').val(cod);
        $('#nomb_caja').val(nomb);
        $('#id_sucursal').selectpicker('val', sucur);
        $('#estado_caja').selectpicker('val', est);
    
        $('#id_sucursal').selectpicker('hide');
        $('#nombre_sucursal').val(nombre_sucursal);
        $('#nombre_sucursal').css('display','block');
    
        $('#title-caja').text('Editar Caja');
        $('#mdl-caja').modal('show');
    }
    
}

/* Boton nueva caja */
$('.btn-caja').click( function() {
    $('#cod_caja').val('');
    $('#title-caja').text('Nueva Caja');
    $('#mdl-caja').modal('show');
});

$('#mdl-caja').on('hidden.bs.modal', function() {
    $(this).find('form')[0].reset();
    $('#frm-caja').formValidation('resetForm', true);
    $('#estado_caja').selectpicker('val', 'a');
    $('#id_sucursal').selectpicker('val', '');

    $('#id_sucursal').selectpicker('show');
    // $('#nombre_sucursal').val(nombre_sucursal);
    $('#nombre_sucursal').css('display','none');

});