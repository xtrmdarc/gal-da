$(function() {
    listarIndicadores();
    $('#frm-indicador')
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
            
            codigoInd = $('#cod_ind').val();
            margenVenta = $('#m_venta').val();

            $.ajax({
                dataType: 'JSON',
                type: 'POST',
                url: '?c=Config&a=GuardarI01',
                data: {
                    cod_ind: codigoInd,
                    m_venta: margenVenta
                },
                success: function (datos) {
                    $('#mdl-indicador').modal('hide');
                    listarIndicadores();
                    toastr.info('Se ha modificado correctamente los datos!');
                },
                error: function(jqXHR, textStatus, errorThrown){
                    console.log(errorThrown + ' ' + textStatus);
                }   
            });

          return false;
    });
});

/* Mostrar datos en la tabla */
var listarIndicadores = function(){
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
            "url": "?c=Config&a=ListarI01"
        },
        "columns":[
            {"data":null,"render": function ( data, type, row) {
                return '<i class="fa fa-slack"></i> 0'+cont++;
            }},
            {"data":"dia"},
            {"data":"margen"},
            {"data":null,"render": function ( data, type, row) {
                return '<a class="btn btn-info btn-sm" onclick="editarIndicador('+data.id+',\''+data.dia+'\',\''+data.margen+'\');"><i class="fa fa-pencil"></i></a>';
            }}
        ]
    });
}

/* Editar Indicador */
var editarIndicador = function(cod,dia,margen){
    $('#cod_ind').val(cod);
    $('#m_venta').val(margen);
	$("#mensaje").html("<center><h4>D&iacute;a: " + dia + "</h4></center>");        
	$("#mdl-indicador").modal('show');
}

$('#mdl-indicador').on('hidden.bs.modal', function() {
    $(this).find('form')[0].reset();
    $('#frm-indicador').formValidation('resetForm', true);
});

$(".dec input").keypress(function(event) {
    var valueKey=String.fromCharCode(event.which);
    var keycode=event.which;
    if(valueKey.search('[0-9.]')!=0 && keycode!=8){
        return false;
    }
});

