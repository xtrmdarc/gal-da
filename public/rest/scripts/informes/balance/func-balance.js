$(function() {
    $('#min-1, #max-1').change( function() {
      var ifecha;
      var ffecha;
      ifecha = $("#min-1").val();
      ffecha = $("#max-1").val();
      $.ajax({
        type: "POST",
        url: "?c=Reporte&a=Datos",
        data: {
                ifecha: ifecha,
                  ffecha: ffecha
              },
        dataType: "json",
        success: function(data){
          $('#efe').html("S/"+data[0]);
          $('#efe-l').html("S/"+data[0]);
          $('#tar').html("S/"+data[1]);
          $('#tar-l').html("S/"+data[1]);
          $('#ga').html("S/"+data[2]);
          $('#ga-l').html("S/"+data[2]);
          var op = (parseFloat(data[0]) + parseFloat(data[1])).toFixed(2);
          var ope = (parseFloat(data[0]) - parseFloat(data[2])).toFixed(2);
          $('#t_i').html("S/"+op);
          $('#dif').html("S/"+ope);
          $('#dif-l').html("S/"+ope);
      }
    });
  });
})