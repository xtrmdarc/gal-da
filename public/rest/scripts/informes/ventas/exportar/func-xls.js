var exp_xls = function(){
	ifecha = $("#start").val();
  ffecha = $("#end").val();
  tdoc = $("#tipo_doc").selectpicker('val');
  icaja = $('#cod_cajas').selectpicker('val');

  $.ajax({
      type: "POST",
      url: "?c=Informe&a=ExportExcel",
      data: {
          ifecha: ifecha,
          ffecha: ffecha,
          tdoc: tdoc,
          icaja: icaja
      },
      dataType: "json",
      success: function(item){
      		alert("ddd");
      		var ini = window.open('?c=Informe&a=ExportExcel','_self');
      }
  });

  return false;
}