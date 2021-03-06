//	BUSCAR LISTA DE CLASIFICACION DE PRODUCTO POR CATEGORIA SELECCIONADA
function buscarClasificaciones()
{
	var id_categoria = jQuery("#id_categoria");
	if (id_categoria.val() != "") 
	{
		jQuery.ajax({
			type:"POST",
			url:"vista/ajax/user_ajax_tienda.php?action=buscarClasificacion",
			data:{
				id_categoria: id_categoria.val()
			},
			success:function (response) {
				console.log(response);
				var jsonResponse = JSON.parse(response);
				if (jsonResponse.estado == "ok") 
				{
					jQuery("#id_clasificacion").html('<option value="">-Seleccione la clasificación del producto</option>');
					jQuery("#id_clasificacion").removeAttr("disabled");
					jQuery.each(jsonResponse.data,function (key,value) {
						//console.log("Key: "+key+" | Value: "+value);
						jQuery("#id_clasificacion").append('<option value="'+value['id_clasificacion']+'">'+value['nombre']+'</option>');
					})
				}
			}
		})
	}
}

//	FILTRO DE PRODUCTOS POR CATEGORIA SELECCIONADA
function filtro_productos(id_categoria)
{
	jQuery.ajax({
		type:"POST",
		url:"vista/ajax/user_ajax_tienda.php?action=filtro",
		data:('id_categoria='+id_categoria)
	}).done(function (response) {
		//console.log(response);
		var jsonResponse = JSON.parse(response);
		//console.log(jsonResponse);
		if (jsonResponse.estado == "ok") 
		{
			lista_categorias(id_categoria);

			jQuery(".view_products").html('');
			jQuery.each(jsonResponse.data,function (key,value) {
				
				var imagen = (value['imagen'] == '') ? "sin_imagen.png" : value['imagen'];
				var nombre_producto = value['nombre'].replace(/ /g,'_');

				if (value['estado_promocion'] == null) 
				{
					var texto = '<b>$'+value['venta']+'</b>';
					var venta = value['venta'];
				}
				else
				{
					var texto = '<b>Dcto '+value['descuento']+'%</b><br><s>$'+value['venta']+'</s> <b>$'+value['promocion']+'</b>';
					var venta = value['promocion'];
				}

				jQuery(".view_products").append('<div class="col-xs-12 col-md-3">'+
												'<div class="contenedor_producto">'+
												  	'<img class="card-img-top" src="vista/img/productos/'+imagen+'" alt="'+value['nombre']+'" width="100%" height="auto">'+
												  	'<div class="card-body text-left">'+
												    	'<h5 class="card-title">'+value['nombre']+'</h5>'+
												    	'<!--<b>$'+value['venta']+'</b>-->'+
												    	'<p class="card-text">'+
												    		texto+
												    	'</p>'+
												  	'</div>'+
												  	'<button class="btn btn-primary" type="button" onclick="info_producto('+value['id_producto']+')"><i class="fa fa-eye"></i> Ver</button>'+
												  	'<button onclick=agregar_al_carrito("'+value['id_producto']+'","'+nombre_producto+'","'+venta+'","'+imagen+'") class="btn btn-success">'+
												  		'<i class="fa fa-shopping-cart"></i> Agregar al carrito'+
												  	'</button>'+
											  	'</div>'+
											'</div>');
			});
		}
		else
		{
			jQuery(".view_products").html('');
		}
	});
}

//	LISTA DE CLASIFICACION POR CATEGORIA
function lista_categorias(id_categoria) {
	jQuery.ajax({
		type:"POST",
		url:"vista/ajax/user_ajax_tienda.php?action=buscarClasificacion",
		data:('id_categoria='+id_categoria)
	}).done(function (response) {
		//console.log(response);
		var jsonResponse = JSON.parse(response);
		if (jsonResponse.estado == "ok") 
		{
			jQuery(".view_clasifications").html('');
			jQuery.each(jsonResponse.data,function (key,value) {
				jQuery(".view_clasifications").append('<button class="btn btn-success m-1" onclick="filtro_productos_clasificacion('+value['id_clasificacion']+','+id_categoria+')">'+value['nombre']+
												 '</button>');
			});
		}
	});
}

//	FILTRO DE PRODUCTOS POR CLASIFICACION SELECCIONADA
function filtro_productos_clasificacion(id_clasificacion,id_categoria)
{
	jQuery.ajax({
		type:"POST",
		url:"vista/ajax/user_ajax_tienda.php?action=filtro_clasificacion",
		data:('id_categoria='+id_categoria+'&id_clasificacion='+id_clasificacion)
	}).done(function (response) {
		//console.log(response);
		var jsonResponse = JSON.parse(response);
		//console.log(jsonResponse);
		if (jsonResponse.estado == "ok") 
		{
			lista_categorias(id_categoria);

			jQuery(".view_products").html('');
			jQuery.each(jsonResponse.data,function (key,value) {

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
					var texto = '<b>Dcto '+value['descuento']+'%</b><br><s>$'+value['venta']+'</s> <b>$'+value['promocion']+'</b>';
					var venta = value['promocion'];
				}

				jQuery(".view_products").append('<div class="col-xs-12 col-md-3">'+
												'<div class="contenedor_producto">'+
												  	'<img class="card-img-top" src="vista/img/productos/'+imagen+'" alt="'+value['nombre']+'" width="100%" height="auto">'+
												  	'<div class="card-body text-left">'+
												    	'<h5 class="card-title">'+value['nombre']+'</h5>'+
												    	'<!--<b>$'+value['venta']+'</b>-->'+
												    	'<p class="card-text">'+
												    		texto+
												    	'</p>'+
												  	'</div>'+
												  	'<button class="btn btn-primary" type="button" onclick="info_producto('+value['id_producto']+')"><i class="fa fa-eye"></i> Ver</button>'+
												  	'<button class="btn btn-success" onclick=agregar_al_carrito("'+value['id_producto']+'","'+nombre_producto+'","'+venta+'","'+imagen+'")>'+
												  		'<i class="fa fa-shopping-cart"></i> Agregar al carrito'+
												  	'</button>'+
											  	'</div>'+
											'</div>');
			});
		}
		else
		{
			jQuery(".view_products").html('');
		}
	});
}

//	AGREGAR PRODUCTO AL CARRITO DE COMPRAS
function agregar_al_carrito(id_producto,nombre_producto,precio_venta,imagen) 
{
	jQuery.ajax({
		type:"POST",
		url:"vista/ajax/user_ajax_carrito.php?action=agregar_producto",
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
			    icon: '../adm/vista/modulos/productos/imagenes/'+imagen,
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

//	INFORMACION DEL PRODUCTO
function info_producto(id_producto)
{
	jQuery.ajax({
		type:"POST",
		url:"vista/modulos/user_tienda/info_producto.php",
		data:{
			id_producto: id_producto
		},
		success:function (response) {
			jQuery("#vista").html(response);
		}
	})
}