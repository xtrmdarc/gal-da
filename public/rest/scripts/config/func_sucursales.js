/**
 * Created by louis on 14/05/2018.
 */
var limite_sucursal;
$(function(){
    listarSucursales();
});

$(function() {
    $('#frm-sucursal')
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

            cod_sucursal = $('#cod_sucursal').val();
            nomb_sucursal = $('#nomb_sucursal').val();
            direccion_sucursal = $('#direccion_sucursal').val();
            telefono_sucursal = $('#telefono_sucursal').val();
            moneda_sucursal = $('#moneda_sucursal').val();
            estado_sucursal = $('#estado_sucursal').val();

            $.ajax({
                dataType: 'JSON',
                type: 'POST',
                url: '/ajustesCrudSucursal',
                data: {
                    cod_sucursal: cod_sucursal,
                    nomb_sucursal: nomb_sucursal,
                    direccion_sucursal: direccion_sucursal,
                    telefono_sucursal: telefono_sucursal,
                    moneda_sucursal: moneda_sucursal,
                    estado_sucursal: estado_sucursal,
                    _token : token
                },
                success: function (data) {
                    if(data.cant_sucursal >= limite_sucursal){
                        $('#limite_sucursales_txt').css('display','block');
                        $('#btn-nueva-sucursal').css('display','none');
                    }
                    if(data.cod == 0){
                        toastr.warning('Advertencia, Datos duplicados.');
                        return false;
                    } else if(data.cod == 1){
                        listarSucursales();
                        $('#mdl-sucursal').modal('hide');
                        toastr.success('Datos registrados, correctamente.');
                        $('#limite_sucursales_txt').text(data.cant_sucursal);   
                    } else if(data.cod == 2) {
                        listarSucursales();
                        $('#mdl-sucursal').modal('hide');
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

/* Mostrar datos en la tabla sucursal */
var listarSucursales = function(){

    var token = $('meta[name="csrf-token"]').attr('content');
    var table = $('#table-sucursales')
        .DataTable({
            "destroy": true,
            "responsive": true,
            "dom": "ftp",
            "bSort": false,
            "ajax":{
                "method": "POST",
                "url": "/ajustesListaSucursales",
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
                {"data":"nombre_sucursal"},
                {"data":"direccion"},
                {"data":"telefono"},
                {"data":null,"render": function ( data, type, row) {
                    if(data.estado == 'a'){
                        return '<span class="label label-primary">ACTIVA</span>';
                    } else if (data.estado == 'i'){
                        return '<span class="label label-danger">INACTIVA</span>'
                    }
                }},
                {"data":null,"render": function ( data, type, row) {
                    if(data.plan_id == 1){
                        if(data.plan_estado == '1') {
                            return '<div class="text-right"><button class="btn btn-success btn-xs" onclick="editarSucursal('+data.id_sucursal+',\''+(data.nombre_sucursal?data.nombre_sucursal:'')+'\',\''+(data.direccion?data.direccion:'')+'\',\''+(data.telefono?data.telefono:'')+'\',\''+(data.moneda?data.moneda:'')+'\',\''+(data.estado?data.estado:'')+'\');"><i class="fa fa-edit"></i>Editar</button>';
                        }else {
                            return '<div class="text-right"></div>';
                        }
                    }
                    if(data.plan_id == 2){
                        return '<div class="text-right"><button class="btn btn-success btn-xs" onclick="editarSucursal('+data.id_sucursal+',\''+(data.nombre_sucursal?data.nombre_sucursal:'')+'\',\''+(data.direccion?data.direccion:'')+'\',\''+(data.telefono?data.telefono:'')+'\',\''+(data.moneda?data.moneda:'')+'\',\''+(data.estado?data.estado:'')+'\');"><i class="fa fa-edit"></i>Editar</button>';
                    }
                }}
            ]
        });
}

/* Editar Sucursal */
var editarSucursal = function(cod,nomb,direcc,telef,mone,est){
    $('#cod_sucursal').val(cod);
    $('#nomb_sucursal').val(nomb);
    $('#direccion_sucursal').val(direcc);
    $('#telefono_sucursal').val(telef);
    $('#moneda_sucursal').val(mone);
    $('#estado_sucursal').selectpicker('val', est);
    $('#title-sucursal').text('Editar Sucursal');
    $('#mdl-sucursal').modal('show');
}

/* Boton nueva caja */
$('.btn-sucursal').click( function() {
    $('#cod_sucursal').val('');
    $('#title-sucursal').text('Nueva Sucursal');
    $('#mdl-sucursal').modal('show');
});

$('#mdl-sucursal').on('hidden.bs.modal', function() {
    $(this).find('form')[0].reset();
    $('#frm-sucursal').formValidation('resetForm', true);
    $('#estado_sucursal').selectpicker('val', 'a');
});