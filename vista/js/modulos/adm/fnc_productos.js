//	VER FORMULARIO DE REGISTRO DE PRODUCTO
function nuevo_producto()
{
	//jQuery("#panel_animado").css("display","block");
	//jQuery("#contenido_animado").load("vista/modulos/productos/nuevo_producto.php");
	jQuery("#contenido_productos").load("vista/modulos/productos/nuevo_producto.php");
}

//	BUSCAR LISTA DE CLASIFICACION DE PRODUCTO POR CATEGORIA SELECCIONADA
function buscarClasificaciones()
{
	var id_categoria = jQuery("#id_categoria");
	if (id_categoria.val() != "") 
	{
		jQuery.ajax({
			type:"POST",
			url:"vista/ajax/ajax_productos.php?action=buscarClasificacion",
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

//	CALCULAR PRECIO DE VENTA
function calcularVenta()
{
	var costo 		= jQuery("#costo");
	var utilidad  	= jQuery("#utilidad");
	var venta  		= jQuery("#venta");

	if (costo.val() != "") 
	{
		if (utilidad.val() != "") 
		{
			var valor_costo 	= parseInt(costo.val());
			var valor_utilidad  = parseInt(utilidad.val());
			var valor_ganancia = (valor_costo * valor_utilidad) / 100;
			var valor_venta = (valor_costo + valor_ganancia);
			venta.val(valor_venta);
		}
		else
		{
			utilidad.focus();
		}
	}
	else
	{
		costo.focus();
	}
}

// 	CALCULAR PORCENTAJE DE UTILIDAD
function calcularUtilidad()
{
	var costo 		= jQuery("#costo");
	var utilidad  	= jQuery("#utilidad");
	var venta  		= jQuery("#venta");

	if (costo.val() != "") 
	{
		if (venta.val() != "") 
		{
			var valor_costo 	= parseInt(costo.val());
			var valor_venta  	= parseInt(venta.val());
			var valor_utilidad 	= Math.round(((valor_venta * 100) / valor_costo) - 100);

			utilidad.val(valor_utilidad);
		}
		else
		{
			venta.focus();
		}
	}
	else
	{
		costo.focus();
	}
}

//	VALIDACION DE FORMULARIO DE REGISTRO
function salvar_producto(action)
{
	var nombre 				= jQuery("#nombre");
	var id_marca 			= jQuery("#id_marca");
	var id_categoria 		= jQuery("#id_categoria");
	var id_clasificacion 	= jQuery("#id_clasificacion");
	var cantidad 			= jQuery("#cantidad");
	var id_unidad 			= jQuery("#id_unidad");
	var costo 				= jQuery("#costo");
	var utilidad 			= jQuery("#utilidad");
	var venta 				= jQuery("#venta");

	var campos = [nombre,id_marca,id_categoria,id_clasificacion,cantidad,id_unidad,costo,utilidad,venta];
	var j = 9;	

	jQuery("#alert_registro").css('display','none');
	jQuery("#alert_registro").html('');

	for (var i = 0; i < campos.length; i++) 
	{
		if(campos[i].val() == ''){
			jQuery("#alert_registro").css('display','block');
			jQuery("#alert_registro").html("El campo '"+campos[i].attr('data-name')+"' Es obligatorio.");
			campos[i].focus();
			break;
		}
		else{
			j = j - 1;
		}
	}
	
	if (j == 0) 
	{
		
		switch(action)
		{
			case 'registrar':

				jQuery(".modal").modal('toggle');
				jQuery('.modal-title').html('¿Desea registrar el producto en el sistema?');
				jQuery(".modal-body").html('Click en <b>Aceptar</b> para realizar el registro.');
				jQuery(".modal-footer").html('<button type="button" class="btn btn-secondary modal-btn-cancel" data-dismiss="modal">Cancelar</button><button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

				jQuery('.modal-btn-accept').on('click',function () {
					var form 		= document.getElementById('form_registro_producto');
					var formData 	= new FormData(form);

					jQuery.ajax({
						type:"POST",
						url:"vista/ajax/ajax_productos.php?action=registrar",
						data:formData,
						contentType:false,
						processData:false,
						success:function (response) {
							//console.log(response);
							var jsonResponse = JSON.parse(response);
							if (jsonResponse.estado == "registrado") 
							{
								jQuery('.modal-title').html('Registro exitoso');
								jQuery(".modal-body").html('El producto ha sido registrado en el sistema correctamente');
								jQuery(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

								jQuery(".modal-btn-accept").click(function () {
									jQuery(".modal").modal('toggle');
									jQuery("#panel_animado").css("display","none");
									loadPage('productos');
								});
							}
							else if (jsonResponse.estado == "error") 
							{
								jQuery('.modal-title').html('Ha ocurrido un error!');
								jQuery(".modal-body").html(jsonResponse.data);
								jQuery(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

								jQuery(".modal-btn-accept").click(function () {
									jQuery(".modal").modal('toggle');
								});
							}
						}
					});

				});
				break;

			case 'actualizar':

				jQuery(".modal").modal('toggle');
				jQuery('.modal-title').html('¿Desea actualizar el producto en el sistema?');
				jQuery(".modal-body").html('Click en <b>Aceptar</b> para realizar la actualzación.');
				jQuery(".modal-footer").html('<button type="button" class="btn btn-secondary modal-btn-cancel" data-dismiss="modal">Cancelar</button><button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

				jQuery('.modal-btn-accept').on('click',function () {
					var form 		= document.getElementById('form_registro_producto');
					var formData 	= new FormData(form);

					jQuery.ajax({
						type:"POST",
						url:"vista/ajax/ajax_productos.php?action=actualizar",
						data:formData,
						contentType:false,
						processData:false,
						success:function (response) {
							console.log(response);
							var jsonResponse = JSON.parse(response);
							if (jsonResponse.estado == "actualizado") 
							{
								jQuery('.modal-title').html('Actualizacion exitosa');
								jQuery(".modal-body").html('El producto ha sido actualizado correctamente.');
								jQuery(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

								jQuery(".modal-btn-accept").click(function () {
									jQuery(".modal").modal('toggle');
									jQuery("#panel_animado").css("display","none");
									loadPage('productos');
								});
							}
							else if (jsonResponse.estado == "error") 
							{
								jQuery('.modal-title').html('Ha ocurrido un error!');
								jQuery(".modal-body").html(jsonResponse.data);
								jQuery(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

								jQuery(".modal-btn-accept").click(function () {
									jQuery(".modal").modal('toggle');
								});
							}
						}
					});

				});
				break;
		}

		
	}
}

// 	EDITAR PRODUCTO SELECCIONADO
function editar_producto(id_producto)
{
	jQuery.ajax({
		type:"POST",
		url:"vista/modulos/productos/editar_producto.php",
		data:('id_producto='+id_producto)
	}).done(function (respuesta) {
		//jQuery("#panel_animado").css("display","block");
		//jQuery("#contenido_animado").html(respuesta);
		jQuery("#contenido_productos").html(respuesta);
	})
}

//	CAMBIAR ESTADO DE PRODUCTO SELECCIONADO
function estado_producto(estado,id_producto)
{
	jQuery.ajax({
		type:"POST",
		url:"vista/ajax/ajax_productos.php?action=estado",
		data:{
			estado: estado,
			id_producto: id_producto
		},
		success:function (response) {
			var jsonResponse = JSON.parse(response);
			if (jsonResponse.estado == "ok") 
			{
				loadPage('productos');
			}
			else
			{
				jQuery(".modal").modal('toggle');
				jQuery('.modal-title').html('Ha ocurrido un error!');
				jQuery(".modal-body").html(jsonResponse.data);
				jQuery(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

				jQuery(".modal-btn-accept").click(function () {
					jQuery(".modal").modal('toggle');
				});
			}
		}
	})
}

//	FILTRO DE PRODUCTOS POR CATEGORIA SELECCIONADA
function filtro_productos(id_categoria)
{
	jQuery.ajax({
		type:"POST",
		url:"vista/ajax/ajax_productos.php?action=filtro",
		data:('id_categoria='+id_categoria)
	}).done(function (response) {
		jQuery(".view_products").html(response);
	})
}

//	ESTADO DE ATRIBUTOS DE PRODUCTO
function eliminar_atributo(id_atributo,id_producto)
{
	jQuery(".modal").modal('toggle');
	jQuery('.modal-title').html('Desea eliminar el atributo seleccionado?');
	jQuery(".modal-body").html('Da click en <b>Aceptar</b> para eliminar este atributo del producto.');
	jQuery(".modal-footer").html('<button type="button" class="btn btn-secondary modal-btn-cancel" data-dismiss="modal">Cancelar</button><button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

	jQuery(".modal-btn-accept").click(function () {
		jQuery.ajax({
			type:"POST",
			url:"vista/ajax/ajax_productos.php?action=estado_atributo",
			data:{
				id_atributo: id_atributo,
				id_producto: id_producto
			},
			success:function (response) {
				var jsonResponse = JSON.parse(response);
				if (jsonResponse.estado == "ok") 
				{
					jQuery(".modal").modal("toggle");
					editar_producto(id_producto);
				}
				else if (jsonResponse.estado == "error") 
				{
					jQuery('.modal-title').html('Ha ocurrido un error');
					jQuery(".modal-body").html(jsonResponse.data);
					jQuery(".modal-footer").html('<button type="button" class="btn btn-secondary modal-btn-cancel" data-dismiss="modal">Cancelar</button><button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

					jQuery(".modal-btn-accept").click(function () {
						jQuery(".modal").modal("toggle");
					});
				}
			}
		})
	});
}

//	MOSTRAR GALERIA DE IMAGENES DE UN PRODUCTO SELECCIONADO
function galeriaProducto(id_producto)
{
	jQuery.ajax({
		type:"POST",
		url:"vista/modulos/productos/galeria_producto.php",
		data:('id_producto='+id_producto)
	}).done(function (respuesta) {
		jQuery("#contenido_productos").html(respuesta);
	});
}

//	SUBIR IMAGEN DE PRODUCTO
function subir_imagen(id_producto)
{
	var imagen = jQuery("#imagen");

	jQuery(".alert_imagen").css("display","none");
	jQuery(".alert_imagen").html("");

	if (imagen.val() != '') 
	{
		jQuery(".modal").modal("toggle");
		jQuery(".modal-title").html('¿Esta seguro de cargar esta imagen al servidor?');
		jQuery(".modal-body").html('Da click en "<b>Continuar</b>" para subir el archivo.');
		jQuery(".modal-footer").html('<button type="button" class="btn btn-secondary modal-btn-cancel" data-dismiss="modal">Cancelar</button><button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

		jQuery(".modal-btn-accept").click(function () {
			
			var form 		= document.getElementById('form_subir_imagen');
			var formData 	= new FormData(form);

			jQuery.ajax({
				type:"POST",
				url:"vista/ajax/ajax_productos.php?action=subir_imagen",
				data:formData,
				contentType:false,
				processData:false,
				success:function (response) {
					console.log(response);
					var jsonResponse = JSON.parse(response);
					if (jsonResponse.estado == "success") 
					{
						jQuery(".modal-title").html('Cargue exitoso');
						jQuery(".modal-body").html('Se ha subido la imagen del producto correctamente!');
						jQuery(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

						jQuery(".modal-btn-accept").click(function () {
							jQuery(".modal").modal("toggle");
							galeriaProducto(id_producto);
						});
					}
					else if (jsonResponse.estado == "error") 
					{
						jQuery(".modal-title").html('Ha ocurrido un error');
						jQuery(".modal-body").html(jsonResponse.data);
						jQuery(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

						jQuery(".modal-btn-accept").click(function () {
							jQuery(".modal").modal("toggle");
							galeriaProducto(id_producto);
						});
					}
				}
			})

		});

	}
	else
	{
		jQuery(".alert_imagen").css("display","block");
		jQuery(".alert_imagen").html("Seleccione una imagen para cargar, formatos permitidos (.png, .jpg, .jpeg)");
	}
}

//	CAMBIAR ESTADO DE IMAGEN DE PRODUCTO
function estado_imagen(estado,id_producto,id_imagen)
{
	jQuery.ajax({
		type:"POST",
		url:"vista/ajax/ajax_productos.php?action=estado_imagen",
		data:{
			estado: 	estado,
			id_producto:id_producto,
			id_imagen: 	id_imagen
		},
		success:function (response) {
			var jsonResponse = JSON.parse(response);
			if (jsonResponse.estado == "success") 
			{
				galeriaProducto(id_producto);
			}
			else
			{
				console.log(response);
			}
		}
	})
}

//	CREAR PROMOCION DE PRODUCTO SELECCIONADO
function promocion_producto(id_producto,venta,nombre)
{
	//console.log("Nombre -> "+nombre+" / Id Producto -> "+id_producto+" / Precio Venta -> $"+venta);
	jQuery(".modal").modal('toggle');
	jQuery(".modal-title").html('Crear promoción');
	jQuery(".modal-body").html(	'<p style="text-align:center;"><b>'+nombre+'</b></p>'+
							'<form id="form_registro_promocion">'+
								'<input type="hidden" name="id_producto" value="'+id_producto+'">'+
								'<p>Precio de venta ($)</p>'+
								'<input class="form-control" type="number" min="0" name="venta" id="venta" value="'+venta+'">'+
								'<p>Porcentaje de descuento (%)</p>'+
								'<input class="form-control" type="number" min="0" name="dcto" id="dcto" value="0" onblur=calcularPromocion("porcentaje")>'+
								'<p>Precio promoción ($)</p>'+
								'<input class="form-control" type="number" min="0" name="precio" id="precio" value="0">'+
							'</form>'+
							'<button class="btn btn-primary btn-block" onclick="crear_promocion()">Generar promoción</button>');
	jQuery(".modal-footer").html('');
}

// 	CALCULAR PROMOCION
function calcularPromocion(tipo)
{
	var venta 	= jQuery("#venta");
	var dcto  	= jQuery("#dcto");
	var precio 	= jQuery("#precio");

	switch(tipo)
	{
		case "porcentaje":
			//	CALCULAR EL PRECIO DE PROMOCION CON EL PORCENTAJE DE DESCUENTO
			var valor_dcto = (parseInt(venta.val()) * parseInt(dcto.val())) / 100;
			var precio_promocion = parseInt(venta.val()) - parseInt(valor_dcto);

			precio.val(precio_promocion);

			break;

		case "precioVenta":
			// 	CALCULAR EL PORCENTAJE DE DESCUENTO CON EL PRECIO DE PROMOCION INGRESADO
			var porcentaje 	= Math.round( 100 - (((parseInt(precio.val()) * 100) / parseInt(venta.val()))));

			dcto.val(porcentaje);
			break;
	}

}

//	CREAR PROMOCION DEL PRODUCTO SELECCIONADO
function crear_promocion()
{
	var form 		= document.getElementById('form_registro_promocion');
	var formData 	= new FormData(form);

	jQuery.ajax({
		type:"POST",
		url:"vista/ajax/ajax_productos.php?action=crear_promocion",
		data:formData,
		contentType:false,
		processData:false,
		success:function (response) {
			console.log(response);
			var jsonResponse = JSON.parse(response);
			if (jsonResponse.estado == "success") 
			{
				jQuery(".modal-title").html('Registro exitoso');
				jQuery(".modal-body").html('Se ha registrado la promoción del producto correctamente.');
				jQuery(".modal-footer").html('<button class="btn btn-primary modal-btn-accept">Aceptar</button>');

				jQuery(".modal-btn-accept").click(function () {
					jQuery(".modal").modal('toggle');
					loadPage('productos');
				});

			}
			else if (jsonResponse.estado == "error") 
			{
				jQuery(".modal-title").html('Ha ocurrido un error');
				jQuery(".modal-body").html(jsonResponse.data);
				jQuery(".modal-footer").html('<button class="btn btn-primary modal-btn-accept">Aceptar</button>');

				jQuery(".modal-btn-accept").click(function () {
					jQuery(".modal").modal('toggle');
				});
			}
		}
	})

}