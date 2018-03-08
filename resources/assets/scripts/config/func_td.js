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
                url: '?c=Config&a=GuardarTD',
                data: {
                    cod_td: cod_td,
                    serie: serie,
                    numero: numero
                },
                success: function (datos) {
                    $('#mdl-tipodoc').modal('hide');
                    listarTiposDoc();
                    toastr.info('Se ha modificado correctamente los datos!');
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
    var table = $('#table')
    .DataTable({
        "destroy": true,
        "responsive": true,
        "dom": "ftp",
        "bSort": false,
        "ajax":{
            "method": "POST",
            "dataType": "JSON",
            "url": "?c=Config&a=ListarTD"
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
