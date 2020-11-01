//	BUSCAR LISTA DE CLASIFICACION DE PRODUCTO POR CATEGORIA SELECCIONADA
function buscarClasificaciones()
{
	var id_categoria = $("#id_categoria");
	if (id_categoria.val() != "") 
	{
		$.ajax({
			type:"POST",
			url:"vista/ajax/ajax_tienda.php?action=buscarClasificacion",
			data:{
				id_categoria: id_categoria.val()
			},
			success:function (response) {
				console.log(response);
				var jsonResponse = JSON.parse(response);
				if (jsonResponse.estado == "ok") 
				{
					$("#id_clasificacion").html('<option value="">-Seleccione la clasificación del producto</option>');
					$("#id_clasificacion").removeAttr("disabled");
					$.each(jsonResponse.data,function (key,value) {
						//console.log("Key: "+key+" | Value: "+value);
						$("#id_clasificacion").append('<option value="'+value['id_clasificacion']+'">'+value['nombre']+'</option>');
					})
				}
			}
		})
	}
}

//	FILTRO DE PRODUCTOS POR CATEGORIA SELECCIONADA
function filtro_productos(id_categoria)
{
	$.ajax({
		type:"POST",
		url:"vista/ajax/ajax_tienda.php?action=filtro",
		data:('id_categoria='+id_categoria)
	}).done(function (response) {
		//console.log(response);
		var jsonResponse = JSON.parse(response);
		//console.log(jsonResponse);
		if (jsonResponse.estado == "ok") 
		{
			lista_categorias(id_categoria);

			$(".view_products").html('');
			$.each(jsonResponse.data,function (key,value) {
				
				var imagen = (value['imagen'] == '') ? "sin_imagen.png" : value['imagen'];
				var nombre_producto = value['nombre'].replace(/ /g,'_');

				if (value['estado_promocion'] == null) 
				{
					var texto = '<b>$'+value['venta']+'</b>';
					var venta = value['venta'];
				}
				else
				{
					var texto = '<s>$'+value['venta']+'</s> <b>$'+value['promocion']+'</b>';
					var venta = value['promocion'];
				}

				$(".view_products").append('<div class="col-xs-12 col-md-3">'+
												'<div class="contenedor_producto">'+
												  	'<img class="card-img-top" src="app/adm/vista/modulos/productos/imagenes/'+imagen+'" alt="'+value['nombre']+'" width="100%" height="auto">'+
												  	'<div class="card-body text-left">'+
												    	'<h5 class="card-title">'+value['nombre']+'</h5>'+
												    	'<!--<b>$'+value['venta']+'</b>-->'+
												    	'<p class="card-text">'+
												    		texto+
												    	'</p>'+
												  	'</div>'+
												  	'<button class="btn btn-primary" onclick=window.open("info/'+value['id_producto']+'","_self")>'+
												  		'<i class="fa fa-eye"></i> Ver producto'+
												  	'</button>'+
												  	'<button onclick=agregar_al_carrito("'+value['id_producto']+'","'+nombre_producto+'","'+venta+'","'+imagen+'") class="btn btn-success">'+
												  		'<i class="fa fa-shopping-cart"></i> Agregar al carrito'+
												  	'</button>'+
											  	'</div>'+
											'</div>');
			});
		}
		else
		{
			$(".view_products").html('');
		}
	});
}

//	LISTA DE CLASIFICACION POR CATEGORIA
function lista_categorias(id_categoria) {
	$.ajax({
		type:"POST",
		url:"vista/ajax/ajax_tienda.php?action=buscarClasificacion",
		data:('id_categoria='+id_categoria)
	}).done(function (response) {
		//console.log(response);
		var jsonResponse = JSON.parse(response);
		if (jsonResponse.estado == "ok") 
		{
			$(".view_clasifications").html('');
			$.each(jsonResponse.data,function (key,value) {
				//console.log(value);
				$(".view_clasifications").append('<button class="btn btn-success m-1" onclick="filtro_productos_clasificacion('+value['id_clasificacion']+','+id_categoria+')">'+value['nombre']+
												 '</button>');
			});
		}
	});
}

//	FILTRO DE PRODUCTOS POR CLASIFICACION SELECCIONADA
function filtro_productos_clasificacion(id_clasificacion,id_categoria)
{
	$.ajax({
		type:"POST",
		url:"vista/ajax/ajax_tienda.php?action=filtro_clasificacion",
		data:('id_categoria='+id_categoria+'&id_clasificacion='+id_clasificacion)
	}).done(function (response) {
		//console.log(response);
		var jsonResponse = JSON.parse(response);
		//console.log(jsonResponse);
		if (jsonResponse.estado == "ok") 
		{
			lista_categorias(id_categoria);

			$(".view_products").html('');
			$.each(jsonResponse.data,function (key,value) {
				
				var id_producto = value['id_producto'];
				var imagen = (value['imagen'] == '') ? "sin_imagen.png" : value['imagen'];
				var nombre_producto = value['nombre'].replace(/ /g,'_');

				if (value['estado_promocion'] == null) 
				{
					var texto = '<b>$'+value['venta']+'</b>';
					var venta = value['venta'];
				}
				else
				{
					var texto = '<s>$'+value['venta']+'</s> <b>$'+value['promocion']+'</b>';
					var venta = value['promocion'];
				}

				$(".view_products").append('<div class="col-xs-12 col-md-3">'+
												'<div class="contenedor_producto">'+
												  	'<img class="card-img-top" src="app/adm/vista/modulos/productos/imagenes/'+imagen+'" alt="'+value['nombre']+'" width="100%" height="auto">'+
												  	'<div class="card-body text-left">'+
												    	'<h5 class="card-title">'+value['nombre']+'</h5>'+
												    	'<!--<b>$'+value['venta']+'</b>-->'+
												    	'<p class="card-text">'+
												    		texto+
												    	'</p>'+
												  	'</div>'+
												  	'<button class="btn btn-primary" onclick=window.open("info/'+value['id_producto']+'","_self")>'+
												  		'<i class="fa fa-eye"></i> Ver producto'+
												  	'</button>'+
												  	'<button onclick=agregar_al_carrito("'+value['id_producto']+'","'+nombre_producto+'","'+venta+'","'+imagen+'") class="btn btn-success">'+
												  		'<i class="fa fa-shopping-cart"></i> Agregar al carrito'+
												  	'</button>'+
											  	'</div>'+
											'</div>');
			});
		}
		else
		{
			$(".view_products").html('');
		}
	});
}

//	AGREGAR PRODUCTO AL CARRITO DE COMPRAS
function agregar_al_carrito(id_producto,nombre_producto,precio_venta,imagen) 
{
	//console.log("Id Producto -> "+id_producto+"/ Nombre Producto -> "+nombre_producto+"/ $"+precio_venta);
	$.ajax({
		type:"POST",
		url:"vista/ajax/ajax_carrito.php?action=agregar_producto",
		data:{
			id_producto: 	id_producto,
			nombre: 		nombre_producto,
			venta: 			precio_venta,
			imagen: 		imagen
		},
		success:function (response) {
			console.log(response);
			var jsonResponse = JSON.parse(response);
			if (jsonResponse.estado == "agregado") 
			{
				//NOTIFICACION PUSH
				Push.create("Click Store", {
			    body: "Se ha agregado el producto al carrito de compras.",
			    icon: 'app/adm/vista/modulos/productos/imagenes/'+imagen,
			    timeout: 4000,
			    onClick: function () {
			        window.focus();
			        this.close();
			    	}
				}); 
			}
		}
	});
}