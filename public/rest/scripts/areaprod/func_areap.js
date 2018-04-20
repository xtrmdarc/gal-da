$(function() {
	pedidosMesa();
	pedidosMostrador();
	pedidosDelivery();
	setInterval(pedidosMesa, 10000);
	setInterval(pedidosMostrador,10000); 
});	

/* Mostrar todos los pedidos realizados en las mesas */
var pedidosMesa = function(){
	moment.locale('es');
	$('#list_pedidos_mesa').empty();
	$('#cant_pedidos_mesa').empty();
	$.ajax({     
        type: "post",
        dataType: "json",
		url: 'cocina/ListarM',
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
        success: function (data){
        $.each(data, function(i, item) {
    		var horaPedido = moment(item.fecha_pedido).fromNow();
    		var cantidadPedido = parseInt(item.Total.nro_p);
    		if(parseInt(cantidadPedido) > 0){
    			$('#cant_pedidos_mesa').text(item.Total.nro_p);
					var sound = new buzz.sound("assets/sound/ding_ding", {
						formats: [ "ogg", "mp3", "aac" ]
					});
					sound.play();
    		}
    		if (item.id_tipo == 2){
				probar = 'primary';
				nombar = 'En espera';
				accion = 'atendido';
    		} else if(item.id_tipo == 1){
    			if(item.estado == 'a'){
					probar = 'primary';
					nombar = 'En espera';
					accion = 'preparacion';
	    		} else if(item.estado == 'p'){
					probar = 'warning';
					nombar = 'En preparacion';
					accion = 'atendido';
	    		}
    		}

    		$('#list_pedidos_mesa')
				.append(
					$('<li class="success-element limost"/>')
					.append(
						$('<div class="row"/>')
							.append(
								$('<div class="col-md-1" style="text-align: center;"/>')
									.append(
										$('<strong/>')
										.html(item.nro_mesa+'<br>'+item.desc_m)
								)
							)
							.append(
								$('<div class="col-md-4"/>')
									.append(
										$('<span/>')
										.html(item.cantidad+' '+item.nombre_p+' <span class="label label-info">'+item.desc_p+
										'</span>&nbsp;<span class="label label-warning">'+item.CProducto.desc_c+
										'</span><br><i class="fa fa-comment"></i> <small class="text-navy"><em>'+item.comentario+'</em>')
								)
							)
							.append(
								$('<div class="col-md-2" style="text-align: center;"/>')
									.append(
										$('<span/>')
										.html(horaPedido)
								)
							)
							.append(
								$('<div class="col-md-2" style="text-align: center;"/>')
									.append(
										$('<div class="progress progress-striped active" style="margin-bottom: -20px;"/>')
										.append(
											$('<div style="width: 100%" aria-valuemax="50" aria-valuemin="0" role="progressbar" class="progress-bar progress-bar-'+probar+'"/>')
												.append(
													$('<span/>')
													.html(nombar)
										)
									)
								)
							)
							.append(
								$('<div class="col-md-2"/>')
									.append(
										$('<span/>')
										.html(item.nombres+' '+item.ape_paterno)
								)
							)
							.append(
								$('<div class="col-md-1" style="text-align: center;"/>')
									.append(
											$('<a onclick="'+accion+'('+item.id_pedido+','+item.id_prod+',\''+item.fecha_pedido+'\');"/>')
												.append(
												$('<button class="btn btn-outline btn-primary dim" type="button" style="margin-bottom: 0px !important;margin-top: -5px !important;"/>')
												.append(
													$('<i class="fa fa-check"/>')
										)
									)
								)
							)
						)
					);				
    		})
        }
    });
}

/* Mostrar todos los pedidos realizados en el mostrador o para llevar */
var pedidosMostrador = function(){
	moment.locale('es');
	$('#list_pedidos_most').empty();
	$('#cant_pedidos_most').empty();
	$.ajax({     
        type: "post",
        dataType: "json",
		url: 'cocina/ListarMO',
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
        success: function (data){
        $.each(data, function(i, item) {
    		var horaPedido = moment(item.fecha_pedido).fromNow();
    		var cantidadPedido = parseInt(item.Total.nro_p);
    		if(parseInt(cantidadPedido) > 0){
    			$('#cant_pedidos_most').text(item.Total.nro_p);
    			var sound = new buzz.sound("assets/sound/ding_ding", {
						formats: [ "ogg", "mp3", "aac" ]
					});
					sound.play();
    		}
    		if (item.id_tipo == 2){
	    			mprobar = 'primary';
	    			mnombar = 'En espera';
	    			maccion = 'atendido';
    		} else if(item.id_tipo == 1){
    				if(item.estado == 'a'){
	    			mprobar = 'primary';
	    			mnombar = 'En espera';
	    			maccion = 'preparacion';
	    		} else if(item.estado == 'p'){
	    			mprobar = 'warning';
	    			mnombar = 'En preparacion';
	    			maccion = 'atendido';
	    		}
    		}
    		$('#list_pedidos_most')
				.append(
					$('<li class="success-element limost"/>')
					.append(
						$('<div class="row"/>')
							.append(
								$('<div class="col-md-1" style="text-align: center;"/>')
									.append(
										$('<strong/>')
										.html('<i class="fa fa-slack"></i> '+item.nro_pedido)
								)
							)
							.append(
								$('<div class="col-md-4"/>')
									.append(
										$('<span/>')
										.html(item.cantidad+' '+item.nombre_p+' <span class="label label-info">'+item.desc_p+
										'</span>&nbsp;<span class="label label-warning">'+item.CProducto.desc_c+
										'</span><br><i class="fa fa-comment"></i> <small class="text-navy"><em>'+item.comentario+'</em>')
								)
							)
							.append(
								$('<div class="col-md-2" style="text-align: center;"/>')
									.append(
										$('<span/>')
										.html(horaPedido)
								)
							)
							.append(
								$('<div class="col-md-2" style="text-align: center;"/>')
									.append(
										$('<div class="progress progress-striped active" style="margin-bottom: -20px;"/>')
										.append(
											$('<div style="width: 100%" aria-valuemax="50" aria-valuemin="0" role="progressbar" class="progress-bar progress-bar-'+mprobar+'"/>')
												.append(
													$('<span/>')
													.html(mnombar)
										)
									)
								)
							)
							.append(
								$('<div class="col-md-2"/>')
									.append(
										$('<span/>')
										.html(item.nombres+' '+item.ape_paterno)
								)
							)
							.append(
								$('<div class="col-md-1" style="text-align: center;"/>')
									.append(
											$('<a onclick="'+maccion+'('+item.id_pedido+','+item.id_prod+',\''+item.fecha_pedido+'\');"/>')
												.append(
												$('<button class="btn btn-outline btn-primary dim" type="button" style="margin-bottom: 0px !important;margin-top: -5px !important;"/>')
												.append(
													$('<i class="fa fa-check"/>')
										)
									)
								)
							)
						)
					);			
    		})
        }
    });
}

/* Mostrar todos los pedidos realizados en el mostrador o para llevar */
var pedidosDelivery = function(){
	moment.locale('es');
	$('#list_pedidos_del').empty();
	$('#cant_pedidos_del').empty();
	$.ajax({     
        type: "post",
        dataType: "json",
		url: 'cocina/ListarDE',
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
        success: function (data){
        $.each(data, function(i, item) {
    		var horaPedido = moment(item.fecha_pedido).fromNow();
    		var cantidadPedido = parseInt(item.Total.nro_p);
    		if(parseInt(cantidadPedido) > 0){
    			$('#cant_pedidos_del').text(item.Total.nro_p);
    			var sound = new buzz.sound("assets/sound/ding_ding", {
						formats: [ "ogg", "mp3", "aac" ]
					});
					sound.play();
    		}
    		if (item.id_tipo == 2){
	    			mprobar = 'primary';
	    			mnombar = 'En espera';
	    			maccion = 'atendido';
    		} else if(item.id_tipo == 1){
    				if(item.estado == 'a'){
	    			mprobar = 'primary';
	    			mnombar = 'En espera';
	    			maccion = 'preparacion';
	    		} else if(item.estado == 'p'){
	    			mprobar = 'warning';
	    			mnombar = 'En preparacion';
	    			maccion = 'atendido';
	    		}
    		}
    		$('#list_pedidos_del')
				.append(
					$('<li class="success-element limost"/>')
					.append(
						$('<div class="row"/>')
							.append(
								$('<div class="col-md-1" style="text-align: center;"/>')
									.append(
										$('<strong/>')
										.html('<i class="fa fa-slack"></i> '+item.nro_pedido)
								)
							)
							.append(
								$('<div class="col-md-4"/>')
									.append(
										$('<span/>')
										.html(item.cantidad+' '+item.nombre_p+' <span class="label label-info">'+item.desc_p+
										'</span>&nbsp;<span class="label label-warning">'+item.CProducto.desc_c+
										'</span><br><i class="fa fa-comment"></i> <small class="text-navy"><em>'+item.comentario+'</em>')
								)
							)
							.append(
								$('<div class="col-md-2" style="text-align: center;"/>')
									.append(
										$('<span/>')
										.html(horaPedido)
								)
							)
							.append(
								$('<div class="col-md-2" style="text-align: center;"/>')
									.append(
										$('<div class="progress progress-striped active" style="margin-bottom: -20px;"/>')
										.append(
											$('<div style="width: 100%" aria-valuemax="50" aria-valuemin="0" role="progressbar" class="progress-bar progress-bar-'+mprobar+'"/>')
												.append(
													$('<span/>')
													.html(mnombar)
										)
									)
								)
							)
							.append(
								$('<div class="col-md-2"/>')
									.append(
										$('<span/>')
										.html(item.nombres+' '+item.ape_paterno)
								)
							)
							.append(
								$('<div class="col-md-1" style="text-align: center;"/>')
									.append(
											$('<a onclick="'+maccion+'('+item.id_pedido+','+item.id_prod+',\''+item.fecha_pedido+'\');"/>')
												.append(
												$('<button class="btn btn-outline btn-primary dim" type="button" style="margin-bottom: 0px !important;margin-top: -5px !important;"/>')
												.append(
													$('<i class="fa fa-check"/>')
										)
									)
								)
							)
						)
					);			
    		})
        }
    });
}

var preparacion = function(cod_ped,cod_prod,fecha_p){
	$.ajax({
      dataType: 'JSON',
      type: 'POST',
      url: '?c=AreaProd&a=Preparacion',
      data: {
      	cod_ped: cod_ped,
      	cod_prod: cod_prod,
      	fecha_p: fecha_p
      },
      success: function (datos) {
      	pedidosMesa();
		pedidosMostrador();
		pedidosDelivery();
      },
      error: function(jqXHR, textStatus, errorThrown){
          console.log(errorThrown + ' ' + textStatus);
      }   
  });
}

var atendido = function(cod_ped,cod_prod,fecha_p){
	$.ajax({
      dataType: 'JSON',
      type: 'POST',
      url: '?c=AreaProd&a=Atendido',
      data: {
      	cod_ped: cod_ped,
      	cod_prod: cod_prod,
      	fecha_p: fecha_p
      },
      success: function (datos) {
      	pedidosMesa();
		pedidosMostrador();
		pedidosDelivery();
      },
      error: function(jqXHR, textStatus, errorThrown){
          console.log(errorThrown + ' ' + textStatus);
      }   
  });
}
