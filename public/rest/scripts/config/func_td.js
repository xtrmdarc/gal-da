$(function() {
    listarTiposDoc();
    $('#frm-tipodoc')
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
            
            cod_td = $('#cod_td').val();
            serie = $('#serie').val();
            numero = $('#numero').val();

            $.ajax({
                dataType: 'JSON',
                type: 'POST',
                url: '/ajustesGuardarTipoDocumento',
                data: {
                    cod_td: cod_td,
                    serie: serie,
                    numero: numero
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (datos,cod) {
                    $('#mdl-tipodoc').modal('hide');
                    listarTiposDoc();
                    toastr.success('Se ha modificado correctamente los datos!');
                },
                error: function(jqXHR, textStatus, errorThrown){
                    console.log(errorThrown + ' ' + textStatus);
                }   
            });

          return false;
    });
});

/* Mostrar datos en la tabla tipo de documentos */
var listarTiposDoc = function(){
    var cont = 1;
    var token = $('meta[name="csrf-token"]').attr('content');
    var table = $('#table')
    .DataTable({
        "destroy": true,
        "responsive": true,
        "dom": "ftp",
        "bSort": false,
        "ajax":{
            "method": "POST",
            "dataType": "JSON",
            "url": "/ajustesListaTipoDocumento",
            "dataSrc" : "",
            headers: {
                'X-CSRF-TOKEN': token
            }
        },
        "columns":[
            {"data":null,"render": function ( data, type, row) {
                return '<i class="fa fa-slack"></i> 0'+cont++;
            }},
            {"data":"descripcion"},
            {"data":"serie"},
            {"data":"numero"},
            {"data":null,"render": function ( data, type, row) {
                return '<a class="btn btn-success btn-xs" onclick="editarTipoDoc('+data.id_tipo_doc+',\''+data.descripcion+'\',\''+data.serie+'\',\''+data.numero+'\');"><i class="fa fa-edit"></i> Editar</a>';
            }}
        ]
    });
}

/* Editar datos del tipo de documento */
function editarTipoDoc(cod,desc,ser,num){
    $('#cod_td').val(cod);
    $('#serie').val(ser);
    $('#numero').val(num);
	$("#mensaje").html("<center><h4>Documento: " + desc + "</h4></center>");        
	$("#mdl-tipodoc").modal('show');
}

$('#mdl-tipodoc').on('hidden.bs.modal', function() {
    $(this).find('form')[0].reset();
    $('#frm-tipodoc').formValidation('resetForm', true);
});
