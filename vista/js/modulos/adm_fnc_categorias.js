/*REGISTRAR CATEGORIAS*/
function nueva_categoria()
{
	jQuery("#panel_animado").css("display","block");
	jQuery("#contenido_animado").load("vista/modulos/adm_categorias/nueva_categoria.php");
}

/*VALIDACION Y REGISTRO DE CATEGORIA*/
function salvar_categoria(ac)
{
	var errores = [];

	var nombre			= jQuery("#nombre");
	var descripcion 	= jQuery("#descripcion");

	var campos = [nombre,descripcion];
	var j = 2;

	jQuery("#alert_registro").css("display","none");
	jQuery(".form-control").css("border","1px solid #AAA");

	for (var i = 0; i < campos.length; i++) 
	{
		if(campos[i].val() == "")
		{
			jQuery("#alert_registro").css("display","block");
			jQuery("#alert_registro").html("Diligencie el campo en el formulario para continuar!");
			campos[i].css("border","2px solid red");
			campos[i].focus();
			break;
		}
		else
		{
			j = j - 1;
		}
	}

	if (j == 0) 
	{
		var exp3 = /[a-zA-Z0-9 a-zA-Z0-9]/;
		if (! exp3.test(nombre.val())) 
		{
			errores.push("Error #1: No ingrese caracteres especiales en el campo 'Nombre'");
		}

		if (! exp3.test(descripcion.val())) 
		{
			errores.push("Error #2: No ingrese caracteres especiales en el campo 'Descripcion'");
		}

		
		if (errores.length == 0) 
		{
			jQuery(".modal").modal('toggle');
			jQuery(".modal-title").html('¿Desea registrar esta Categoria en el sistema?');
			jQuery(".modal-body").html('');
			jQuery(".modal-footer").html('<button type="button" class="btn btn-secondary modal-btn-cancel" data-dismiss="modal">Cancelar</button><button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

			jQuery(".modal-btn-accept").click(function () {
				
				var form 		= document.getElementById('form_registro_categoria');
				var formData 	= new FormData(form);

				jQuery.ajax({
					type:"POST",
					url:"vista/ajax/adm_ajax_categorias.php?ac="+ac,
					data: formData,
					contentType:false,
					processData:false,
					success:function (respuesta) 
					{
						console.log(respuesta);
						var jsonResponse = JSON.parse(respuesta);

						if (jsonResponse.estado == "registrado") 
						{
							jQuery(".modal-title").html('Registro exitoso');
							jQuery(".modal-body").html('Se ha registrado la categoria correctamente en el sistema.')
							jQuery(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

							jQuery(".modal-btn-accept").click(function () {
								jQuery(".modal").modal('toggle');
								jQuery("#panel_animado").css("display","none");
								loadPage('categorias');
							});
						}
						else if(jsonResponse.estado == "ya_existe")
						{
							jQuery(".modal-title").html('Registro invalido');
							jQuery(".modal-body").html('La categoria ya se encuentra registrada en el sistema.')
							jQuery(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

							jQuery(".modal-btn-accept").click(function () {
								jQuery(".modal").modal('toggle');
							});
						}
						else if(jsonResponse.estado == "actualizado")
						{
							jQuery(".modal-title").html('Actualizacion exitosa');
							jQuery(".modal-body").html('Se ha actualizado la categoria de forma correcta en el sistema.')
							jQuery(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

							jQuery(".modal-btn-accept").click(function () {
								jQuery(".modal").modal('toggle');
								jQuery("#panel_animado").css("display","none");
								loadPage('categorias');
							});
						}
						else if(jsonResponse.estado == "error")
						{
							jQuery(".modal-title").html('Ha ocurrido un error!');
							jQuery(".modal-body").html(jsonResponse.data);
							jQuery(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

							jQuery(".modal-btn-accept").click(function () {
								jQuery(".modal").modal('toggle');
							});
						}
					}
				})
			});

		}
		else
		{
			jQuery("#alert_registro").css("display","block");
			jQuery("#alert_registro").html("");

			for (var i = 0; i < errores.length; i++) 
			{
				jQuery("#alert_registro").append("> "+errores[i]+"<br>");
			}

			console.log(errores);
		}

	}

}

/*EDITAR CATEGORIA*/
function editar_categoria(id_categoria)
{
	jQuery.ajax({
		type:"POST",
		url:"vista/modulos/adm_categorias/editar_categoria.php",
		data:('id_categoria='+id_categoria)
	}).done(function (respuesta) {
		jQuery("#panel_animado").css("display","block");
		jQuery("#contenido_animado").html(respuesta);
	})
}

/*ESTADO CATEGORIA*/
function estado_categoria(estado,id_categoria)
{
	jQuery.ajax({
		type:"POST",
		url:"vista/ajax/adm_ajax_categorias.php?ac=3",
		data:('estado='+estado+'&id_categoria='+id_categoria)
	}).done(function(respuesta) {
		var jsonResponse = JSON.parse(respuesta);
		if (jsonResponse.estado == "success") 
		{
			loadPage('categorias');
		}
		else if(jsonResponse.estado == "error")
		{
			jQuery(".modal").modal('toggle');
			jQuery(".modal-title").html('Ha ocurrido un error!');
			jQuery(".modal-body").html(jsonResponse.data);
			jQuery(".modal-footer").html('<button type="button" class="btn btn-secondary modal-btn-cancel" data-dismiss="modal">Cancelar</button><button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

			jQuery(".modal-btn-accept").click(function () {
				jQuery(".modal").modal('toggle');
			});
		}
	});
}

// 	AGREGAR NUEVA CLASIFICACION DE CATEGORIA
function agregar_clasificacion(id_categoria,categoria)
{
	jQuery.ajax({
		type:"POST",
		url:"vista/modulos/adm_categorias/nueva_clasificacion.php",
		data:{
			id_categoria: 	id_categoria,
			categoria: 		categoria
		},
		success:function (response) {
			jQuery("#panel_animado").css("display","block");
			jQuery("#contenido_animado").html(response);
		}
	});
}

//	VALIDACION DE FORMULARIO DE CLASIFICACION
function salvar_clasificacion(ac)
{
	jQuery("#alert_registro").css("display","none");
	jQuery("#alert_registro").html("");

	var clasificacion = jQuery("#nombre");
	if (clasificacion.val() != "") 
	{
		switch(ac)
		{
			case '4':
				// 	REGISTRO
				jQuery(".modal").modal('toggle');
				jQuery(".modal-title").html('¿Desea registrar esta Clasificación en el sistema?');
				jQuery(".modal-body").html('Da click en <b>Aceptar</b> para realizar el registro');
				jQuery(".modal-footer").html('<button type="button" class="btn btn-secondary modal-btn-cancel" data-dismiss="modal">Cancelar</button><button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

				jQuery(".modal-btn-accept").click(function () {

					var form 		= document.getElementById('form_registro_clasificacion');
					var formData 	= new FormData(form);

					jQuery.ajax({
						type:"POST",
						url:"vista/ajax/adm_ajax_categorias.php?ac=4",
						data:formData,
						contentType:false,
						processData:false,
						success:function (response) {
							var jsonResponse = JSON.parse(response);
							if (jsonResponse.estado == "registrado") 
							{
								jQuery(".modal").modal('toggle');
								jQuery("#panel_animado").css("display","none");
								loadPage('categorias');
							}
							else
							{
								jQuery(".modal-title").html('Ha ocurrido un error!');
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

			case '5':
				// 	ACTUALIZACION
				jQuery(".modal").modal('toggle');
				jQuery(".modal-title").html('¿Desea actualizar esta Clasificación en el sistema?');
				jQuery(".modal-body").html('Da click en <b>Aceptar</b> para realizar la actualización');
				jQuery(".modal-footer").html('<button type="button" class="btn btn-secondary modal-btn-cancel" data-dismiss="modal">Cancelar</button><button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

				jQuery(".modal-btn-accept").click(function () {

					var form 		= document.getElementById('form_registro_clasificacion');
					var formData 	= new FormData(form);

					jQuery.ajax({
						type:"POST",
						url:"vista/ajax/adm_ajax_categorias.php?ac=5",
						data:formData,
						contentType:false,
						processData:false,
						success:function (response) {
							var jsonResponse = JSON.parse(response);
							if (jsonResponse.estado == "actualizado") 
							{
								jQuery(".modal").modal('toggle');
								jQuery("#panel_animado").css("display","none");
								loadPage('categorias');
							}
							else
							{
								jQuery(".modal-title").html('Ha ocurrido un error!');
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
	else
	{
		jQuery("#alert_registro").css("display","block");
		jQuery("#alert_registro").html("Ingrese el nombre de la nueva clasificacion a registrar");
		clasificacion.focus();
	}
}

//	EDITAR CLASIFICACION
function editar_clasificacion(id_clasificacion,nombre_clasificacion)
{
	jQuery.ajax({
		type:"POST",
		url:"vista/modulos/adm_categorias/editar_clasificacion.php",
		data:{
			id_clasificacion: 	id_clasificacion,
			clasificacion: 		nombre_clasificacion
		},
		success:function (response) {
			jQuery("#panel_animado").css("display","block");
			jQuery("#contenido_animado").html(response);
		}
	});
}

//	ACTUALIZAR ESTADO DE CLASIFICACION
function estado_clasificacion(estado,id_clasificacion)
{
	jQuery.ajax({
		type:"POST",
		url:"vista/ajax/adm_ajax_categorias.php?ac=6",
		data:{
			estado: 			estado,
			id_clasificacion: 	id_clasificacion
		},
		success:function (response) {
			var jsonResponse = JSON.parse(response);
			if (jsonResponse.estado == "ok") 
			{
				loadPage('categorias');
			}
			else
			{
				jQuery(".modal-title").html('Ha ocurrido un error!');
				jQuery(".modal-body").html(jsonResponse.data);
				jQuery(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

				jQuery(".modal-btn-accept").click(function () {
					jQuery(".modal").modal('toggle');
				});
			}
		}
	})
}