(function(){
	
	var ordenes =[];

$(function() {
	console.log(ordenes);
	pedidosMesa();
	pedidosMostrador();
	pedidosDelivery();
	setInterval(pedidosMesa, 10000);
	setInterval(pedidosMostrador,10000); 
	setupSocketio();
});	

/* Mostrar todos los pedidos realizados en las mesas */
var pedidosMesa = function(){
	/*moment.locale('es');
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
    });*/
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
	
var setupSocketio = function(){
	
	var socket = io.connect('http://192.168.10.10:3000');
	
    socket.on("pedido-registrado:App\\Events\\PedidoRegistrado", function(data){
		console.log(ordenes);
		for(var i = 0; i<ordenes.length; i++)
		{
			if(data.orden.pedido.id_pedido == ordenes[i].pedido.id_pedido){
				console.log('se encontró');
				var pedidos =data.orden.items;
				var N = data.orden.items.length;
				
				for(var j = 0; j< N; j++)
				{
					$('#'+ordenes[i].IdListaPedidos).append(NewPedido(ordenes[i].items.length,data.orden.pedido.fecha_pedido, pedidos[j].nombre_prod , pedidos[j].cantidad, pedidos[j].comentario, pedidos[j].fecha));
					ordenes[i].items.push(pedidos[j]);
				}
				
				return;
			}
		}
		
		console.log('es nuevo');
		NewOrder(data.orden);
		
		

		console.log(data.orden);
    });
}


function NewOrder(orden){
	
	

	var pedidos = orden.items;

	var sepuede = '<span style="color:red">asdas</span>';
	var pedidosHtml = ``;
	
	var id_pedidoListaPedidos = 'ul_pedidos_'+orden.pedido.id_pedido;
	var id_ordenDemora =  'timer_demora_' + orden.pedido.id_pedido;
	//console.log(orden.pedido.fecha_pedido);

	for (var i = 0; i< pedidos.length;i++)
	{	
		pedidosHtml = pedidosHtml + NewPedido(i,orden.pedido.fecha_pedido, pedidos[i].nombre_prod , pedidos[i].cantidad, pedidos[i].comentario, pedidos[i].fecha);
	}

	var html = ` <div class="col-sm-6 col-md-4 col-lg-3 pedido-post-it" >
					<div class="card post-it ">
						<div class="card-header post-it-header ">
							<div class="row">
								<div class="col-4 col-sm-4 text-left">
									<span><b>${sepuede} </b></span>
								</div>
								<div id="${id_ordenDemora}"  class="col-4 col-sm-4 text-center">
									00:00 
								</div>
								<div class="col-4 col-sm-4 text-right">
									<!--<a class="btn btn-primary" style="float:right;" href="#">Info</a>--!>
									&#9432
								</div>
							</div>
						</div>
							
						<ul id="${id_pedidoListaPedidos}"  class="list-group list-group-flush">

							`+pedidosHtml + `
							
						</ul>

					</div>
				</div>`;

	$('#pedidos-container')
		.append(html);
	
	orden.IdListaPedidos = id_pedidoListaPedidos;
	ordenes.push(orden);
	StartTimerDemora(id_ordenDemora,orden.pedido.fecha_pedido);
}

function NewPedido(id, idpedido, nombre, cantidad, comentarios,fecha ){

	var id_pedidoDemora =  `pedido_demora_`+id+idpedido;
	StartTimerDemora(id_pedidoDemora,fecha);	
	return `<li class="list-group-item">
				<div class="row"   >		
					<div class="col-7 col-sm-7">
						${nombre}
						<div class="row">
							<div class="col-sm-12">
								${comentarios}
							</div>
						</div>
					</div>
					<div id = "${id_pedidoDemora}" class="col-3 col-sm-3 "><span class="card-text"> 4m </span></div>
					<div class="col-2 col-sm-2 text-right"><a class="btn btn-primary"  href="#">V</a></div>
				</div>
			</li>
			`;
	
}

function StartTimerDemora(id_elemento,tiempo){

	var now = new Date(0,0,0,0,0,0,0);
	var start = new Date() - new Date(tiempo);
	var demora = new Date(0,0,0,0,0,0,0);
	console.log(start);
	console.log(demora);
	console.log(tiempo);
	//console.log(start.getTime());
	console.log(demora.getTime());
	//console.log(tiempo.getTime());
	setInterval(function(){
		//var startMS = start.getTime();
		//var startMS = nowMS - id_elemento.getTime();
        start += 1000;
		demora.setTime(now.getTime() + start);
		console.log(demora);
        var timer = document.getElementById(id_elemento);
        if(timer){
            timer.innerHTML =/* digits2(demora.getHours()) + ":" +*/ digits2(demora.getMinutes())+ ":"+digits2(demora.getSeconds());
            //clock.innerHTML = 'hola';
		}
		
	} , 1000 );
}

function digits2(number) {
    return (number < 10 ? '0' : '') + number
}

})();
 